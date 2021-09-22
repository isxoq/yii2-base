<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 15.07.2021, 13:38
 */

namespace backend\controllers;

use common\models\Client;
use Faker\Factory;
use soft\helpers\ArrayHelper;
use soft\web\SoftController;
use yii\filters\AccessControl;

class FakerController extends SoftController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

       public function actionWorker()
       {
           $branches = Branch::getAll();
           $factory = $this->factoryEn();

           $password = \Yii::$app->security->generatePasswordHash('123456');

           foreach ($branches as $branch) {

               for ($i = 1; $i <= 5; $i++) {
                   $worker = new User([
                       'type_id' => $i == 1 ? User::TYPE_MANAGER : User::TYPE_CONSULTANT,
                       'status' => User::STATUS_ACTIVE,
                       'firstname' => $factory->firstName,
                       'lastname' => $factory->lastName,
                       'branch_id' => $branch->id,
                       'username' => 'user' . $branch->id . $i,
                       'auth_key' => \Yii::$app->security->generateRandomString(),
                       'password_hash' => $password,
                   ]);

                   $worker->save();
                   dump($worker->errors);

               }

           }
       }

       public function actionReception()
       {
           $branches = Branch::getAll();
           $factory = $this->factoryEn();
           $statuses = Status::getAll();
           $sids = ArrayHelper::getColumn($statuses, 'id');

           foreach ($branches as $branch) {

               $workers = $branch->consultantWorkers;
               $wids = ArrayHelper::getColumn($workers, 'id');
               for ($i = 1; $i <= 50; $i++) {

                   $userId = $this->arrayRand($wids);

                   $client = new Client();
                   $client->firstname = $factory->firstName;
                   $client->lastname = $factory->lastName;
                   $client->phone = $this->generateUzbPhone();
                   $client->address = $factory->address;
                   $client->come_from = $factory->sentence;
                   $client->user_id = $userId;
                   $client->branch_id = $branch->id;
                   $client->status_id = $this->arrayRand($sids);
                   if ($client->save()) {
                       $reception = new Reception([
                           'client_id' => $client->id,
                           'comment' => $factory->text,
                           'user_id' => $userId,
                           'branch_id' => $branch->id
                       ]);

                       if (!$reception->save()) {
                           dd($reception->errors);
                       }
                   } else {
                       dd($client->errors);
                   }
               }
           }
       }

//    public function actionReceptionDate()
//    {
//        $models = Reception::getAll();
//        $beginTime = strtotime('-10 days');
//        $endTime = time();
//
//        foreach ($models as $model) {
//            $model->detachBehaviors();
//            $date = rand($beginTime, $endTime);
//            $model->created_at = $date;
//            $model->updated_at = $date + rand(0, 86400);
//            $model->save(false);
//        }
//    }


    //<editor-fold desc="Additional methods" defaultstate="collapsed">

    public function factoryEn()
    {
        return Factory::create('en_US');
    }

    public function factoryRu()
    {
        return Factory::create('ru_RU');
    }

    public function generateUzbPhone()
    {
        $n1 = mt_rand(100, 999);
        $n2 = mt_rand(10, 99);
        $n3 = mt_rand(10, 99);
        $codes = ['90', '91', '93', '94', '95', '97', '99'];
        $key = array_rand($codes);
        $code = $codes[$key];
        return "+998($code) $n1-$n2-$n3";
    }

    public function arrayRand($array = [])
    {
        $key = array_rand($array);
        return $array[$key];
    }

    //</editor-fold>
}