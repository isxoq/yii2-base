<?php

namespace backend\controllers;

use common\models\search\UserSearch;
use common\models\Branch;
use common\models\User;
use soft\web\SoftController;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class UserController extends SoftController
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
     * Lists all User models.
     * @return string
     */
    public function actionIndex($branch_id)
    {
        $branch = Branch::findModel($branch_id);
        $query = $branch->getWorkers();
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($query);

        return $this->render('index', [
            'branch' => $branch,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->ajaxCrud->viewAction($model);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function actionCreate($branch_id)
    {
        $branch = Branch::findModel($branch_id);
        $model = new User();
        $model->branch_id = $branch_id;
        $model->scenario = User::SCENARIO_CREATE_BY_ADMIN;
        $model->status = User::STATUS_ACTIVE;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
            $model->auth_key = Yii::$app->security->generateRandomString();
            if ($model->save(false)) {
                return $this->redirect(['index', 'branch_id' => $branch_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'branch' => $branch
        ]);
    }

    /**
     * @throws \yii\base\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->status = User::STATUS_ACTIVE;
        $model->scenario = User::SCENARIO_UPDATE_BY_ADMIN;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (!empty($model->password)) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
                $model->auth_key = Yii::$app->security->generateRandomString();
            }
            if ($model->save(false)) {
                return $this->redirect(['index', 'branch_id' => $model->branch_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'branch' => $model->branch
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->ajaxCrud->closeModalResponse();
    }

    /**
     * Delete multiple existing User model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful,
     * the browser will be redirected to the 'index' page.
     * @param integer $id
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
     * @return User
     * @throws yii\web\NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = User::find()->andWhere(['id' => $id])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }
}
