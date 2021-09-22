<?php

namespace backend\controllers;

use common\models\Client;
use common\models\Doctor;
use common\models\Order;
use common\models\User;
use console\models\AuthAssignment;
use yii\base\Exception;
use soft\helpers\Html;
use Yii;
use soft\web\SoftController;
use backend\models\LoginForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

/**
 * Site controller
 */
class SiteController extends SoftController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'error', 'index', 'cache-flush', 'excel', 'server'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return \yii\web\Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = 'blank';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->can('admin')) {
                return $this->goBack();
            } else {
                Yii::$app->user->logout();
            }
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionCacheFlush()
    {
        Yii::$app->cache->flush();
        Yii::$app->session->setFlash('success', 'Cache has been successfully cleared');
        return $this->back();
    }

    public function actionExcel()
    {
        set_time_limit(0);

        $inputFile = 'excel/malumot.xlsx';


        try {

            $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFile);


        } catch (Exception $e) {

            die('Error : ');
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for ($row = 1; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, Null, true, false);

            if ($row == 1) {

                continue;
            }

            $client = new Client();

            $client->hatlov_uz_number = $rowData[0][0];
            $client->first_name = $rowData[0][1];
            $client->last_name = $rowData[0][2];
            $client->middle_name = $rowData[0][3];
            $client->born_date = strtotime($rowData[0][4]);
            $client->street = $rowData[0][5];
            $client->house_number = $rowData[0][6];
            $client->address = $rowData[0][7];
            $client->birth_certificate = $rowData[0][8];
            $client->jshshir = $rowData[0][9];
            $client->passport = $rowData[0][10];

            $client->save();

//            print_r($client->errors);
        }
    }

    public function actionServer()
    {

    }

}
