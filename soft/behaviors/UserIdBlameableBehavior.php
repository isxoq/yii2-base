<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 19.06.2021, 14:24
 */

namespace soft\behaviors;


use yii\behaviors\BlameableBehavior;

class UserIdBlameableBehavior extends BlameableBehavior
{

    public $createdByAttribute = 'user_id';

}