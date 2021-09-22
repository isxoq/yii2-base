<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "tariff".
 *
 * @property int $id
 * @property int|null $minimum_km Minimalka kilometri
 * @property int|null $minimum_sum Minimalka narxi
 * @property int $km_sum 1 km narxi
 * @property int|null $status
 * @property int|null $outra_city_km_sum Shahar tashqarisi 1 km narxi
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class Tariff extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tariff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['km_sum', 'required'],
            [['minimum_km', 'minimum_sum', 'km_sum', 'status', 'outra_city_km_sum'], 'integer'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'minimum_km' => 'Minimalka kilometri',
            'minimum_sum' => 'Minimalka narxi',
            'km_sum' => '1 km narxi',
            'outra_city_km_sum' => 'Shahar tashqarisi 1 km narxi',
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    //</editor-fold>
}
