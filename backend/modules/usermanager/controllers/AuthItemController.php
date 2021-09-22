<?php

namespace backend\modules\usermanager\controllers;

use Yii;
use backend\modules\usermanager\models\AuthItem;
use yii\data\ActiveDataProvider;
use soft\web\SoftController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class AuthItemController extends SoftController
{

    /**
    * {@inheritdoc}
    */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'bulk-delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ]
        ];
    }

    /**
    * Lists all AuthItem models.
    * @return mixed
    */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AuthItem::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
    * Displays a single AuthItem model.
    * @param string $id
    * @return string
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->ajaxCrud->viewAction($model);
    }

    /**
    * Creates a new AuthItem model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return string
    */
    public function actionCreate()
    {
        $model = new AuthItem();
        return $this->ajaxCrud->createAction($model);
    }

    /**
    * Updates an existing AuthItem model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param string $id
    * @return string
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        return $this->ajaxCrud->updateAction($model, [
            'title' => $model->name,
        ]);
    }

    /**
    * Deletes an existing AuthItem model.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * @param string $id
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->ajaxCrud->closeModalResponse();
    }

    /**
    * Delete multiple existing AuthItem model.
    * For ajax request will return json object
    * and for non-ajax request if deletion is successful,
    * the browser will be redirected to the 'index' page.
    * @param string $id
    * @return mixed
    */
    public function actionBulkdelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }
        return $this->ajaxCrud->closeModalResponse();
    }

    /**
    * Finds a single model for crud actions
    * @param $id
    * @return AuthItem
    * @throws yii\web\NotFoundHttpException
    */
    public function findModel($id)
    {
        $model = AuthItem::find()->andWhere(['name' => $id])->one();
        if ($model == null){
            not_found();
        }
        return $model;
    }
}
