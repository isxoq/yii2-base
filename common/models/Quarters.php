<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quarters".
 *
 * @property int $id
 * @property int $district_id
 * @property string|null $name
 */
class Quarters extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quarters';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['district_id'], 'required'],
            [['district_id'], 'integer'],
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
            'district_id' => Yii::t('app', 'District ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    //</editor-fold>

    public function getDistrict()
    {
        return $this->hasOne(Districts::class, ['id' => 'district_id']);
    }
}
