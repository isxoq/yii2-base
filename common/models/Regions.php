<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "regions".
 *
 * @property int $id
 * @property string|null $name
 */
class Regions extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
    * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'regions';
    }

    /**
    * {@inheritdoc}
    */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
    * {@inheritdoc}
    */
    public function labels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
    //</editor-fold>

}
