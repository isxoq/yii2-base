<?php

namespace common\models;

use mohorev\file\UploadImageBehavior;
use soft\helpers\Html;

/**
 *
 * @property-read string $imageUrl
 */
class Driver extends User
{

    const DEFAULT_AVATAR = '/images/driver_default_image.jpg';

    public static function find()
    {
        return parent::find()->andWhere(['type_id' => User::TYPE_CLIENT]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token, 'status' => self::STATUS_ACTIVE, 'type_id' => self::TYPE_CLIENT]);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['uploadImage'] = [
            'class' => UploadImageBehavior::class,
            'attribute' => 'image',
            'deleteOriginalFile' => true,
            'scenarios' => [self::SCENARIO_DEFAULT, self::SCENARIO_UPDATE_CLIENT, self::SCENARIO_CREATE_CLIENT],
            'path' => '@frontend/web/uploads/images/driver/{id}',
            'url' => '/uploads/images/driver/{id}',
            'thumbs' => [
                'preview' => ['width' => 300],
            ],
        ];
        return $behaviors;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->getThumbUploadUrl('image', 'preview') ?? self::DEFAULT_AVATAR;
    }

    /**
     * @param string $width
     * @param array $options
     * @return string
     */
    public function getImageHtmlView($width = '200px', array $options = [])
    {
        $options['width'] = $width;
        return Html::img($this->getImageUrl(), $options);
    }

}