<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "districts".
 *
 * @property int $id
 * @property int $region_id
 * @property string|null $name
 */
class Districts extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'districts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id'], 'required'],
            [['region_id'], 'integer'],
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
            'region_id' => Yii::t('app', 'Region ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    //</editor-fold>

    public function getRegion()
    {
        return $this->hasOne(Regions::class, ['id' => 'region_id']);
    }

}
