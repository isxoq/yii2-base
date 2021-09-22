<?php

use yii\web\MultipartFormDataParser;
use common\models\User;
use yii\web\JsonParser;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'language' => 'uz',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'modules' => [
        'client' => [
            'class' => 'api\modules\client\Module',
        ],
    ],
    'components' => [

        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                ],
            ],
        ],

        'request' => [
            'baseUrl' => '/api',
            'parsers' => [
                'application/json' => JsonParser::class,
                'multipart/form-data' => MultipartFormDataParser::class
            ],
        ],
        'user' => [
            'identityClass' => User::class,
            'enableSession' => false,
            'enableAutoLogin' => false,
            'loginUrl' => null,
            'identityCookie' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'scriptUrl' => '/api/web/index.php',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ]
    ],
    'on beforeRequest' => static function ($event) {
        $languages = ['kr', 'ru', 'uz'];
        $language = Yii::$app->request->headers['Accept-Language'];
        Yii::$app->language = in_array($language, $languages, true) ? $language : 'uz';
    },
    'params' => $params,
];
