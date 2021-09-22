<?php

namespace frontend\modules\user\controllers;

use common\models\User;
use frontend\modules\user\ChangePassword;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `tutor` module
 */
class DefaultController extends Controller
{

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
     * Renders the index view for the module
     * @return string
     */
    public function actionHome()
    {
        return $this->render('home');
    }
    public  function actionPassword()
    {
        $model = new ChangePassword();
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
           $user=Yii::$app->user->identity;
            if (Yii::$app->security->validatePassword($model->current_password,$user->password_hash))
            {
                $user->password_hash=Yii::$app->security->generatePasswordHash($model->new_password);
                $user->save();
                Yii::$app->session->setFlash('success',"Parolingiz o'zgardi");
                return $this->redirect('/user');
            }
            else
                {
                $model->addError('current_password', 'Joriy parol xato!');

            }


        }

        return $this->render('changepassword', [
            'model' => $model,
        ]);
    }

}
