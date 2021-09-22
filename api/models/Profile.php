<?php

namespace api\models;
/*
Project Name: tashxis.loc
File Name: Profile.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/31/2021 6:59 AM
*/


use Yii;
use yii\base\Model;

/**
 * Login form
 *
 * @property-read null|\common\models\User $user
 */
class Profile extends Model
{

    public $auth_key;
    public $first_name;
    public $last_name;
    public $father_name;
    public $birth_date;
    public $gender;
    public $province_id;
    public $region_id;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['auth_key', 'first_name', 'last_name', 'father_name', 'birth_date', 'gender', 'province_id', 'region_id'], 'required']
        ];
    }


}
