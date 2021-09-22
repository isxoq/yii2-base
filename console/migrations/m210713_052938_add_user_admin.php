<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m210713_052938_add_user_admin
 */
class m210713_052938_add_user_admin extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function safeUp()
    {

        $user = User::findOne(1);

        if ($user == null) {
            $user = new User([
                'username' => 'admin',
                'first_name' => 'Admin',
            ]);
            $user->setPassword('admin');
            $user->generateAuthKey();
            $user->status = User::STATUS_ACTIVE;
            if (!$user->save(false)) {
                echo "An error occured while saving user model";
                print_r($user->errors);
                return false;
            }
        }

        $auth = Yii::$app->authManager;
        $auth->removeAll();
        $adminRole = $auth->getRole('admin');
        if ($adminRole == null) {
            $adminRole = $auth->createRole('admin');
            $auth->add($adminRole);
        }
        $auth->assign($adminRole, $user->id);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        return true;
    }
}
