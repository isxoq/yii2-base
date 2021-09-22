<?php

namespace soft\components;

use soft\db\ActiveRecord;
use soft\helpers\ArrayHelper;
use Yii;
use soft\web\SoftController;
use soft\helpers\Html;
use yii\web\Response;

/**
 * Class AjaxCrud component for SoftController
 * @see SoftController::$ajaxCrud
 * @package soft\components
 *
 * @property-read Yii\web\Request $request
 * @property-read Yii\web\Response $response
 * @property-read \yii\web\Controller|\yii\console\Controller $controller
 * @property-read bool $isAjax
 */
class AjaxCrud extends \yii\base\Component
{

    /**
     * @param null $content
     * @param string[] $options
     * @return string
     */
    public function closeButton($content = null, $options = [])
    {
        if ($content == null) {
            $content = Yii::t('site', 'Close');
        }

        if (!isset($options['class'])) {
            $options['class'] = 'btn btn-default pull-right';
        }

        $options['data-dismiss'] = 'modal';
        return Html::button($content, $options);
    }

    /**
     * @param $link
     * @param null $label
     * @param array $options
     * @param string $icon
     * @return string
     */
    public function editButton($link, $label = null, $options = [], $icon = 'pencil')
    {
        if ($label == null) {
            $label = Yii::t('site', 'Edit');
        }
        if (!isset($options['class'])) {
            $options['class'] = 'btn btn-primary';
        }
        $options['role'] = 'modal-remote';
        return Html::a($label, $link, $options, $icon);
    }

    /**
     * @param $editLink
     * @return string
     */
    public function viewFooter($editLink)
    {
        return $this->editButton($editLink) . $this->closeButton();
    }

    /**
     * @param null $content
     * @param string[] $options
     * @return string
     */
    public function saveButton($content = null, $options = [])
    {
        if ($content == null) {
            $content = Yii::t('site', 'Save');
        }

        if (!isset($options['class'])) {
            $options['class'] = 'btn btn-primary';
        }

        $options['type'] = 'submit';
        return Html::button($content, $options);
    }

    /**
     * @return string
     */
    public function modalFormFooter()
    {
        return $this->saveButton() . $this->closeButton();
    }

    /**
     * @param null $label
     * @param string[] $link
     * @param string $icon
     * @return string
     */
    public function createMoreButton($label = null, $link = ['create'], $icon = 'plus')
    {
        if ($label == null) {
            $label = Yii::t('site', 'Create more');
        }
        if (!isset($options['class'])) {
            $options['class'] = 'btn btn-primary';
        }
        $options['role'] = 'modal-remote';
        return Html::a($label, $link, $options, $icon);
    }

    /**
     * @return string
     */
    public function afterCreateFooter()
    {
        return $this->closeButton() . $this->createMoreButton();
    }

    public function closeModal($forceReload = '#crud-datatable-pjax', $options = [])
    {
        $this->formatJson();
        $options['forceClose'] = true;
        if ($forceReload != false) {
            $options['forceReload'] = $forceReload;
        }
        return $options;
    }

    public function closeModalResponse($returnLink = null, $forceReload = '#crud-datatable-pjax')
    {
        if ($this->isAjax) {
            /*
            *   Process for ajax request
            */
            return $this->closeModal($forceReload);

        } else {
            /*
            *   Process for non-ajax request
            */
            if ($returnLink == null){
                $returnLink = Yii::$app->request->referrer ?? ['index'];
            }
            return $this->controller->redirect($returnLink);
        }
    }

    /**
     * @return yii\web\Request
     */
    public function getRequest()
    {
        return Yii::$app->request;
    }

    public function getIsAjax()
    {
        return $this->request->isAjax;
    }

    /**
     * @return yii\web\Response
     */
    public function getResponse()
    {
        return Yii::$app->response;
    }

    /**
     * @return \yii\console\Controller|\yii\web\Controller
     */
    public function getController()
    {
        return Yii::$app->controller;
    }

    /**
     * Response formatini json formatiga o'tkazish
     */
    public function formatJson()
    {
        $this->response->format = Response::FORMAT_JSON;
    }


    /**
     * @param $model ActiveRecord
     * @param array $params
     * @param array $viewParams
     * @return array|string
     * @throws \Exception
     */
    public function viewAction($model, $params = [], $viewParams = [])
    {
        $view = ArrayHelper::getValue($params, 'view', 'view');
        $viewParams['model'] = $model;

        if ($this->isAjax) {

            $title = ArrayHelper::getValue($params, 'title');
            if ($title == null) {
                $title = Yii::t('site', 'View') . "#" . $model->id;
            }

            $content = ArrayHelper::getValue($params, 'content');
            if ($content == null) {
                $content = $this->controller->renderAjax($view, $viewParams);
            }

            $footer = ArrayHelper::getValue($params, 'footer');

            if ($footer == null) {
                $editLink = ArrayHelper::getValue($params, 'editLink', ['update', 'id' => $model->id]);
                $footer = $this->viewFooter($editLink);
            }

            $result = [
                'title' => $title,
                'content' => $content,
                'footer' => $footer,
            ];

            if (isset($params['forceReload'])) {
                $result['forceReload'] = $params['forceReload'];
            }

            $this->formatJson();
            return $result;

        } else {
            return $this->controller->render($view, $viewParams);
        }

    }

    /**
     * @param $model ActiveRecord
     * @param array $params. Quyidagilar params ichida bo'lish mumkin:
     *  - view - string - defaults to `update`
     *  - forceClose - bool - defaults to `true`
     *  - title - string - title for modal. If not set, will be automatically generated
     *  - content - string - content for modal. If not set, will be automatically generated
     *  - footer - string - footer for modal. If not set, will be automatically generated
     *  - returnUrl - string|array - url to redirect after updating when request is not ajax. Defaults to `['view', 'id' => $model->id]`
     *
     * @param array $viewParams
     * @return array|string
     * @throws \Exception
     */
    public function updateAction($model, $params = [], $viewParams = [])
    {

        $request = Yii::$app->request;

        if ($this->isAjax) {

            if ($model->load($request->post()) && $model->save()) {

                $forceClose = ArrayHelper::getValue($params, 'forceClose', true);
                if ($forceClose) {
                    return $this->closeModal();
                } else {
                    return $this->viewAction($model, ['forceReload' => '#crud-datatable-pjax']);
                }

            } else {
                return $this->updateModal($model, $params, $viewParams);
            }

        } else {

            if ($model->load($request->post()) && $model->save()) {
                if (isset($params['returnUrl'])) {
                    $returnUrl = $params['returnUrl'];
                } else {
                    $returnUrl = ['view', 'id' => $model->id];
                }
                return $this->controller->redirect($returnUrl);
            }

            $view = ArrayHelper::getValue($params, 'view', 'update');
            $viewParams['model'] = $model;
            return $this->controller->render($view, $viewParams);
        }

    }

    public function updateModal($model, $params = [], $viewParams = [])
    {
        $view = ArrayHelper::getValue($params, 'view', 'update');
        $viewParams['model'] = $model;

        $title = ArrayHelper::getValue($params, 'title');
        if ($title == null) {
            $title = Yii::t('site', 'Update') . "#" . $model->id;
        }

        $content = ArrayHelper::getValue($params, 'content');
        if ($content == null) {
            $content = $this->controller->renderAjax($view, $viewParams);
        }

        $footer = ArrayHelper::getValue($params, 'footer');

        if ($footer == null) {
            $footer = $this->modalFormFooter();
        }

        $this->formatJson();
        return [
            'title' => $title,
            'content' => $content,
            'footer' => $footer,
        ];

    }

    /**
     * @param $model ActiveRecord
     * @param array $params. Quyidagilar params ichida bo'lish mumkin:
     *  - view - string - defaults to `create`
     *  - forceClose - bool - defaults to `true`
     *  - title - string - title for modal. If not set, will be automatically generated
     *  - content - string - content for modal. If not set, will be automatically generated
     *  - footer - string - footer for modal. If not set, will be automatically generated
     *  - returnUrl - string|array - url to redirect after creating when request is not ajax. Defaults to `['view', 'id' => $model->id]`
     *
     *
     * @param array $viewParams
     * @return array|string
     * @throws \Exception
     */
    public function createAction($model, $params = [], $viewParams = [])
    {

        $request = Yii::$app->request;

        if ($this->isAjax) {

            if ($model->load($request->post()) && $model->save()) {

                $forceClose = ArrayHelper::getValue($params, 'forceClose', true);
                if ($forceClose) {
                    return $this->closeModal();
                } else {
                    return $this->viewAction($model, [ 'footer' => $this->afterCreateFooter(), 'forceReload' => '#crud-datatable-pjax']);
                }

            } else {
                return $this->createModal($model, $params, $viewParams);
            }

        } else {

            if ($model->load($request->post()) && $model->save()) {
                if (isset($params['returnUrl'])) {
                    $returnUrl = $params['returnUrl'];
                } else {
                    $returnUrl = ['view', 'id' => $model->id];
                }
                return $this->controller->redirect($returnUrl);
            }

            $view = ArrayHelper::getValue($params, 'view', 'create');
            $viewParams['model'] = $model;
            return $this->controller->render($view, $viewParams);
        }

    }

    public function createModal($model, $params = [], $viewParams = [])
    {
        $view = ArrayHelper::getValue($params, 'view', 'create');
        $viewParams['model'] = $model;

        $title = ArrayHelper::getValue($params, 'title');
        if ($title == null) {
            $title = Yii::t('site', 'Create a new');
        }

        $content = ArrayHelper::getValue($params, 'content');
        if ($content == null) {
            $content = $this->controller->renderAjax($view, $viewParams);
        }

        $footer = ArrayHelper::getValue($params, 'footer');

        if ($footer == null) {
            $footer = $this->modalFormFooter();
        }

        $this->formatJson();
        return [
            'title' => $title,
            'content' => $content,
            'footer' => $footer,
        ];

    }


    public function debugModal($content)
    {
        $this->formatJson();
        return [

            'title' => "Debug",
            'content' => $content,
            'footer' => $this->closeButton()

        ];
    }


}