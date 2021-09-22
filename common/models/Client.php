<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $phone
 * @property string|null $first_name
 * @property string|null $last_name
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property Order[] $orders
 */
class Client extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['status'], 'integer'],
            [['phone', 'first_name', 'last_name'], 'string', 'max' => 100],
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
            'phone' => 'Tel. raqam',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['client_id' => 'id']);
    }

    //</editor-fold>

    //<editor-fold desc="Static methods" defaultstate="collapsed">

    /**
     * @param $phone string
     * @return \common\models\Client|null
     */
    public static function findByPhone($phone)
    {
        return static::findOne(['phone' => $phone]);
    }

    /**
     * @param string $phone
     * @param string $first_name
     * @param string $last_name
     * @return \common\models\Client|null
     */
    public static function findOrCreate($phone, $first_name = '', $last_name = '')
    {
        $model = static::findByPhone($phone);

        if ($model == null) {
            $model = new Client();
            $model->phone = $phone;
            $model->first_name = $first_name;
            $model->last_name = $last_name;
            $model->save();
        }
        return $model;
    }


    //</editor-fold>



}
