<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car_model".
 *
 * @property int $id
 * @property string $name
 * @property int|null $status
 *
 * @property Car[] $cars
 */
class CarModel extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
    * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'car_model';
    }

    /**
    * {@inheritdoc}
    */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['name'], 'unique'],
        ];
    }

    /**
    * {@inheritdoc}
    */
    public function labels()
    {
        return [
            'name' => 'Model nomi',
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCars()
    {
        return $this->hasMany(Car::className(), ['model_id' => 'id']);
    }
    
    //</editor-fold>
}
