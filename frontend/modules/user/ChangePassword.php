<?php

namespace frontend\modules\user;

use Yii;
use yii\base\Model;

class ChangePassword extends Model
{

    public $current_password;
    public $new_password;
    public $repeat_new_password;

    public function rules()
    {
        return
            [
                [['current_password', 'new_password', 'repeat_new_password'], 'required'],
                [['current_password'], 'string'],
                [['new_password', 'repeat_new_password'], 'string', 'min' => 6, 'max' => 30],
                ['repeat_new_password', 'compare', 'compareAttribute' => 'new_password','message' => t('The re-entered password does not match')],
            ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'current_password'=>t("Current password"),
            'new_password'=>t("New password"),
            'repeat_new_password'=>t("Repeat new password"),

        ];
    }
}