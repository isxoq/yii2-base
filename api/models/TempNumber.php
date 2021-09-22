<?php

namespace api\models;

use backend\modules\eskizsms\components\SendEskizSms;
use Yii;

/**
 * This is the model class for table "temp_number".
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $password
 * @property string $phone_number
 * @property string|null $code
 * @property int|null $expire_at
 */
class TempNumber extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'temp_number';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['type', 'integer'],
            [['phone_number'], 'required'],
            [['expire_at'], 'integer'],
            [['first_name', 'last_name', 'password', 'phone_number'], 'string', 'max' => 100],
            [['code'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'password' => Yii::t('app', 'Password'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'code' => Yii::t('app', 'Code'),
            'expire_at' => Yii::t('app', 'Expired At'),
        ];
    }

    public function sendSmsCode($change = false)
    {

        return true;
        if (is_localhost()) {
            return true;
        }


        if ($change) {

            $message = \Yii::t('app', 'Change Phone on {hostInfo}: {code}', [
                'hostInfo' => \Yii::$app->request->hostInfo,
                'code' => $this->code,
            ]);
            return SendEskizSms::SendSms($this->phone_number, $message);
        }

        $message = \Yii::t('app', 'Activation code of your account on {hostInfo}: {code}', [
            'hostInfo' => \Yii::$app->request->hostInfo,
            'code' => $this->code,
        ]);

        return SendEskizSms::SendSms($this->phone_number, $message);
    }
}
