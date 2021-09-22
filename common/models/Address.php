<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property int $id
 * @property string $name
 * @property int|null $status
 *
 * @property Order[] $orders
 */
class Address extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'name' => 'Manzil nomi',
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['address_id' => 'id']);
    }

    //</editor-fold>

    /**
     * @param $name string
     * @return \common\models\Address|null
     */
    public static function findByName($name)
    {
        return static::findOne(['name' => $name]);
    }

    public static function findOrCreate($name)
    {
        $model = static::findByName($name);
        if ($model == null) {
            $model = new Address();
            $model->name = $name;
            $model->save();
        }
        return $model;
    }
}
