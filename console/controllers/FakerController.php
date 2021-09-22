<?php

namespace console\controllers;

use common\models\Address;
use common\models\Client;
use common\models\Order;
use Yii;
use common\models\Car;
use common\models\CarModel;
use common\models\Driver;
use common\models\User;
use Faker\Factory;
use soft\helpers\ArrayHelper;
use yii\console\Controller;

/**
 *
 * @property-read \Faker\Generator $factory
 */
class FakerController extends Controller
{


    public function actionDriver()
    {
        $factory = $this->getFactory();
        for ($i = 1; $i <= 20; $i++) {
            $model = new Driver();
            $model->first_name = $factory->firstName;
            $model->last_name = $factory->lastName;
            $model->phone = $this->generateUzbPhone();
            $model->save();
        }
    }

    public function actionCar()
    {
        $factory = $this->getFactory();
        $drivers = Driver::getAll();
        $models = CarModel::getAll();
        $model_ids = ArrayHelper::getColumn($models, 'id');
        $colors = ['oq', 'qora', 'kulrang', 'sariq'];

        $transaction = Yii::$app->db->beginTransaction();

        foreach ($drivers as $driver) {

            $model = new Car();
            $model->driver_id = $driver->id;
            $model->model_id = $this->arrayRand($model_ids);
            $model->color = $this->arrayRand($colors);
            $model->description = $factory->text;
            $model->number = $this->generateCarStateNumber();

            if (!$model->save()) {
                print_r($model->errors);
                $transaction->rollBack();
                die();
            }


        }

        $transaction->commit();

        echo "\n***done***\n";
        return true;

    }

    public function actionAddress()
    {
        $factory = $this->getFactory();
        $transaction = Yii::$app->db->beginTransaction();

        Address::deleteAll();

        for ($i = 1; $i <= 30; $i++) {

            $model = new Address();
            $model->name = $factory->address;
            if (!$model->save()) {
                print_r($model->errors);
                $transaction->rollBack();
                die();
            }
        }

        $transaction->commit();

        echo "\n***done***\n";
        return true;

    }

    public function actionClient()
    {
        $factory = $this->getFactory();
        $transaction = Yii::$app->db->beginTransaction();

        for ($i = 1; $i <= 100; $i++) {

            $model = new Client();
            $model->first_name = $factory->firstName;
            $model->last_name = $factory->lastName;
            $model->phone = $this->generateUzbPhone();

            if (!$model->save()) {
                print_r($model->errors);
                $transaction->rollBack();
                die();
            }
        }

        $transaction->commit();

        echo "\n***done***\n";
        return true;

    }

   /* public function actionOrder()
    {
        $factory = $this->getFactory();
        $transaction = Yii::$app->db->beginTransaction();

        for ($i = 1; $i <= 20; $i++) {

            $model = new Order();

            $model->first_name = $factory->firstName;
            $model->last_name = $factory->lastName;
            $model->phone = $this->generateUzbPhone();

            if (!$model->save()) {
                print_r($model->errors);
                $transaction->rollBack();
                die();
            }
        }

        $transaction->commit();

        echo "\n***done***\n";
        return true;

    }*/

    /**
     * @throws \yii\db\Exception
     * @throws \yii\base\Exception
     */
    public function actionUser()
    {

        $branches = Branch::find()->all();

        $manager = 2;
        $reception = 3;
        $moliya = 4;
        $teacher = 5;
        $worker = 6;
        $student = 7;

        $transaction = Yii::$app->db->beginTransaction();
        $flag = true;

        foreach ($branches as $branch) {

            $flag = $flag && $this->createUsers($branch, $manager, 1);
            $flag = $flag && $this->createUsers($branch, $reception, 2);
            $flag = $flag && $this->createUsers($branch, $moliya, 1);
            $flag = $flag && $this->createUsers($branch, $teacher, 10);
            $flag = $flag && $this->createUsers($branch, $worker, 5);
            $flag = $flag && $this->createUsers($branch, $student, 100);
            if (!$flag) {
                break;
            }
        }

        if (!$flag) {
            $transaction->rollBack();
            echo "\nerror\n";
        } else {

            $transaction->commit();
            echo "\nsuccess\n";
        }


    }

    /**
     * @return \Faker\Generator
     */
    private function getFactory()
    {
        return Factory::create();
    }

    /**
     * @return string
     */
    private function generateUzbPhone()
    {
        $n1 = mt_rand(100, 999);
        $n2 = mt_rand(10, 99);
        $n3 = mt_rand(10, 99);
        $codes = ['90', '91', '93', '94', '95', '97', '99'];
        $key = array_rand($codes);
        $code = $codes[$key];
        return "+998($code) $n1-$n2-$n3";
    }

    /**
     * @param array $array
     * @return mixed
     */
    private function arrayRand(array $array = [])
    {
        $key = array_rand($array);
        return $array[$key];
    }

    /**
     * @param array $regions
     */
    private function generateCarStateNumber($regions = [])
    {
        $region_number = (string)(empty($regions) ? 40 : $this->arrayRand($regions));
        $letter1 = strtoupper($this->randomLetter());
        $numbers = (string)(mt_rand(100, 999));
        $letter2 = strtoupper($this->randomLetter());
        $letter3 = strtoupper($this->randomLetter());
        return $region_number . $letter1 . $numbers . $letter2 . $letter3;

    }

    /**
     * @return string
     */
    private function randomLetter()
    {
        $letters = ['a', 'b', 'c', 'd', 'e', 'f', 'o', 'p', 'q', 'w', 'z'];
        return $this->arrayRand($letters);
    }

    /**
     * @throws \yii\base\Exception
     */
    private function createUsers($branch, int $type, int $count = 1)
    {

        $factory = $this->getFactory();

        for ($i = 1; $i <= $count; $i++) {

            $model = new User();
            $model->detachBehaviors();


            $username = $factory->firstName;

            $oldUsers = User::findAll(['username' => $username]);

            if (!empty($oldUsers)) {
                $count = count($oldUsers);
                $username .= '_' . $count;
            }

            $password = strtolower($username);

            $model->username = $username;
            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->password_hash = Yii::$app->security->generatePasswordHash($password);

            $bornInt = mt_rand(strtotime('01-01-1980'), strtotime('31-12-2002'));

            $model->born = date('Y-m-d', $bornInt);
            $model->phone = $this->generateUzbPhone();
            $model->p_phone = $this->generateUzbPhone();
            $model->info = $factory->text;
            $model->user_type_id = $type;
            $model->status = User::STATUS_ACTIVE;
            $model->branch_id = $branch->id;
            $model->created_at = time();
            $model->updated_at = time();
            $model->created_by = 1;

            if (!$model->save()) {
                print_r($model->errors);
                return false;
            } else {
                echo "\n*** " . $model->id . " user created!!!****";
            }

        }

        return true;

    }

}