<?php

namespace common\models;

use mohorev\file\UploadImageBehavior;
use Yii;

/**
 * This is the model class for table "car".
 *
 * @property int $id
 * @property string|null $image
 * @property int|null $driver_id Haydovchi
 * @property int|null $model_id Model
 * @property string|null $color
 * @property int|null $position
 * @property string|null $number Davlat raqami
 * @property int|null $status
 * @property string|null $description
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property Driver $driver
 * @property CarModel $model
 * @property User $updatedBy
 */
class Car extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'car';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['driver_id', 'model_id', 'color'], 'required'],
            [['driver_id', 'model_id', 'position', 'status'], 'integer'],
            [['description'], 'string'],
            [['image'], 'image'],
            [['color', 'number'], 'string', 'max' => 100],
            [['driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => Driver::className(), 'targetAttribute' => ['driver_id' => 'id']],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarModel::className(), 'targetAttribute' => ['model_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => UploadImageBehavior::class,
                'attribute' => 'image',
                'deleteOriginalFile' => true,
                'scenarios' => ['default'],
                'path' => '@frontend/web/uploads/images/cars/{id}',
                'url' => '/uploads/images/cars/{id}',
                'thumbs' => [
                    'preview' => ['width' => 250],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'driver_id' => 'Haydovchi',
            'model_id' => 'Model',
            'color' => 'Rangi',
            'position' => 'Pozitsiya',
            'number' => 'Davlat raqami',
            'description' => 'Izoh',
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
    public function getDriver()
    {
        return $this->hasOne(User::className(), ['id' => 'driver_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(CarModel::className(), ['id' => 'model_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    //</editor-fold>

    public function getImageUrl()
    {
        return $this->getThumbUploadUrl('image', 'preview');
    }
}
