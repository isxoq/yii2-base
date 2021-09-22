<?php

namespace api\modules\client\controllers;

/*
Project Name: taxi.loc
File Name: UserController.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/30/2021 1:41 PM
*/


use api\models\Profile;
use api\models\TempNumber;
use common\models\Districts;
use common\models\Quarters;
use common\models\Regions;
use common\models\User;
use yii\base\BaseObject;
use yii;
use yii\helpers\Inflector;

class UserController extends BaseController
{

    /**
     * Yangi ro'yhatdan o'tish
     * @return array
     */
    public function actionRegister(): array
    {
        $phone = clearPhone(Yii::$app->request->post('phone'));

        $validate = $this->validateFields(Yii::$app->request, ['phone']);

        if (!$validate['success']) {
            return $validate;
        }

        $user = User::findOne(['phone' => $phone]);
        if ($user) {
            return $this->error([], Yii::t('app', 'Phone already registered'));
        }
        $tempNumber = TempNumber::findOne(['phone_number' => $phone]);


        if ($tempNumber) {
            if (($tempNumber->expire_at - time()) <= 0) {
                $tempNumber->code = generateCode();
                $tempNumber->expire_at = time() + 120;
                $tempNumber->save();

                $tempNumber->sendSmsCode();


                return $this->success([
                    'expired_in' => $tempNumber->expire_at - time()
                ], t('code sent'));
            } else {
                return $this->success([
                    'expired_in' => $tempNumber->expire_at - time()
                ], t('code sent'));
            }

        } else {
            $tempNumber = new TempNumber();
        }

        $tempNumber->phone_number = $phone;
        $tempNumber->code = generateCode();
        $tempNumber->expire_at = time() + 120;
        $tempNumber->save();

        $tempNumber->sendSmsCode();

        return $this->success([
            'expired_in' => $tempNumber->expire_at - time()
        ], t('code sent'));
    }

    /**
     * Tasdiqlash
     * @return array
     * @throws \Throwable
     * @throws yii\base\Exception
     * @throws yii\db\StaleObjectException
     */
    public function actionVerifyCode(): array
    {

        $validate = $this->validateFields(Yii::$app->request, ['phone', 'code']);

        if (!$validate['success']) {
            return $validate;
        }

        $phone = clearPhone(Yii::$app->request->post('phone'));
        $code = Yii::$app->request->post('code');

        $tempNumber = TempNumber::findOne(['phone_number' => $phone]);

        if (!$tempNumber) {
            return $this->error([], t('Not found'));
        }

        if (($tempNumber->expire_at - time()) <= 0) {
            return $this->error([], t('Code expired'));
        }

        if ($tempNumber->code != $code) {
            return $this->error([], t('Code error'));
        }

        $login = $phone;

        $user = new User([
            'scenario' => User::SCENARIO_API_CREATE_CLIENT
        ]);
        $user->phone = $phone;
        $user->email = $phone;
        $user->username = $login;
        $user->password_hash = Yii::$app->security->generatePasswordHash("12345678_isx");
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->status = User::STATUS_ACTIVE;
        $user->type_id = User::TYPE_CLIENT;
        $user->save();

        $tempNumber->delete();

        return $this->success($user);
    }

    /**
     * Login
     * @return array
     * @throws yii\base\InvalidConfigException
     */
    public function actionLogin(): array
    {

        $validate = $this->validateFields(Yii::$app->request, ['phone']);

        if (!$validate['success']) {
            return $validate;
        }

        $username = clearPhone(Yii::$app->request->post('phone'));

        $user = User::findClient(clearPhone($username));

        if (!$user) {
            return $this->error([], t('User not found'));
        }

        $tempNumber = TempNumber::findOne(['phone_number' => $username]);


        if ($tempNumber) {
            if (($tempNumber->expire_at - time()) <= 0) {
                $tempNumber->code = generateCode();
                $tempNumber->expire_at = time() + 120;
                $tempNumber->save();

                $tempNumber->sendSmsCode();


                return $this->success([
                    'expired_in' => $tempNumber->expire_at - time()
                ], t('code sent'));
            } else {
                return $this->success([
                    'expired_in' => $tempNumber->expire_at - time()
                ], t('code sent'));
            }

        } else {
            $tempNumber = new TempNumber();
        }
        $tempNumber->phone_number = $username;
        $tempNumber->code = generateCode();
        $tempNumber->expire_at = time() + 120;
        $tempNumber->save();

        $tempNumber->sendSmsCode();

        return $this->success([
            'expired_in' => $tempNumber->expire_at - time()
        ], t('code sent'));

    }

    /**
     * @throws yii\base\InvalidConfigException
     */
    public function actionLoginVerify()
    {

        $validate = $this->validateFields(Yii::$app->request, ['phone', 'code']);

        if (!$validate['success']) {
            return $validate;
        }

        $phone = clearPhone(Yii::$app->request->post('phone'));
        $code = Yii::$app->request->post('code');

        $tempNumber = TempNumber::findOne(['phone_number' => $phone]);

        $user = User::findClient(clearPhone($phone));

        if (!$tempNumber) {
            return $this->error([], t('Not found'));
        }

        if (($tempNumber->expire_at - time()) <= 0) {
            return $this->error([], t('Code expired'));
        }

        if ($tempNumber->code != $code) {
            return $this->error([], t('Code error'));
        }

        $user->scenario = User::SCENARIO_GENERATE_AUTH_KEY;
        $user->generateAuthKey();
        $user->save();
        $tempNumber->delete();
        return $this->success($user);
    }

    public function actionAddProfileInfo()
    {

        $profile = new Profile();
        $profile->auth_key = Yii::$app->request->post('auth_key');
        $profile->first_name = Yii::$app->request->post('first_name');
        $profile->last_name = Yii::$app->request->post('last_name');
        $profile->father_name = Yii::$app->request->post('father_name');
        $profile->birth_date = Yii::$app->request->post('birth_date');
        $profile->gender = Yii::$app->request->post('gender');
        $profile->province_id = Yii::$app->request->post('province_id');
        $profile->region_id = Yii::$app->request->post('region_id');

        if ($profile->validate()) {
            $user = User::findClientByAuthKey($profile->auth_key);
            if (!$user) {
                return $this->notFound();
            }

            $user->scenario = User::SCENARIO_API_ADD_PROFILE_CLIENT;
            $user->first_name = $profile->first_name;
            $user->last_name = $profile->last_name;
            $user->father_name = $profile->father_name;
            $user->birth_date = $profile->birth_date;
            $user->gender = $profile->gender;
            $user->province_id = $profile->province_id;
            $user->region_id = $profile->region_id;
            $user->save();
            return $this->success($user);

        } else {
            return $this->error($profile->errors);
        }


    }

    /**
     * Fieldlar borligini tekshiradi
     * @param yii\web\Request $request
     * @param array $array
     * @return array|bool
     */
    private function validateFields(yii\web\Request $request, array $array)
    {
        foreach ($array as $item) {
            if (!$request->post($item)) {
                return $this->error([
                    'required' => $item
                ], t('Fields Required'));
            }
        }
        return $this->success([]);
    }


    /**
     * @throws yii\base\InvalidConfigException
     */
    public function actionResendRegisterVerifyCode()
    {

        $validate = $this->validateFields(Yii::$app->request, ['phone']);

        if (!$validate['success']) {
            return $validate;
        }

        $tempNumber = TempNumber::find()->andWhere(['phone_number' => clearPhone(Yii::$app->request->post('phone'))])->one();

        if (!$tempNumber) {
            return $this->notFound();
        }

        if ($tempNumber->expire_at > time()) {
            return $this->success([], t("Sms already sent"));
        }

        $tempNumber->code = generateCode();
        $tempNumber->expire_at = time() + 120;
        $tempNumber->save();
        return $this->success([], t("Sms sent"));

    }


    public function actionRegions()
    {
        $regions = Regions::find()->all();
        return $this->success($regions);
    }


    public function actionDistricts($region_id)
    {
        $districts = Districts::find()
            ->joinWith('region')
            ->andWhere(['regions.id' => $region_id])
            ->all();
        return $this->success($districts);
    }

    public function actionQuarters($district_id)
    {
        $quarters = Quarters::find()
            ->joinWith('district')
            ->andWhere(['districts.id' => $district_id])
            ->all();
        return $this->success($quarters);
    }

}