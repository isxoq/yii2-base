<?php

namespace api\modules\client\controllers;
/*
Project Name: taxi.loc
File Name: BaseController.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 8/30/2021 1:41 PM
*/

class BaseController extends \yii\rest\Controller
{
    /**
     * Successfull javob yuborish
     * @param $data
     * @param string $message
     * @return array
     */
    public function success($data, string $message = ""): array
    {
        return [
            'success' => true,
            'message' => t($message),
            'data' => $data
        ];
    }

    /**
     * Topilmaga javob qaytarish
     * @return array
     */
    public function notFound(): array
    {
        return [
            'success' => true,
            'message' => t('Not found'),
            'data' => []
        ];
    }

    /**
     * Xatolik xabarini qaytarish
     * @param $data
     * @param string $message
     * @return array
     */
    public function error($data, $message = ""): array
    {
        return [
            'success' => false,
            'message' => t($message),
            'data' => $data
        ];
    }

}