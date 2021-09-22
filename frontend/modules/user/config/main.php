<?php
$params = array_merge(
    require __DIR__ . '/../../../../common/config/params.php',
    require __DIR__ . '/../../../../common/config/params-local.php',
    require __DIR__ . '/../../../../frontend/config/params.php',
    require __DIR__ . '/../../../../frontend/config/params-local.php',
    require __DIR__ . '/params.php'
);
return [
    'components' => [
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => '@homeUrl/template/adminlte3/base-assets',
                    'js' => ['js/jquery.min.js']
                ],

                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => '@homeUrl/template/adminlte3/base-assets',
                    'css' => [
                        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback',
                        'fontawesome-free/css/all.min.css',
                        'css/adminlte.min.css',
                    ]
                ],

                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => '@homeUrl/template/adminlte3/base-assets',
                    'js' => ['js/bootstrap.bundle.min.js',]
                ],
                'yii\bootstrap4\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                    'js' => [],
                ],
                'yii\bootstrap4\BootstrapAsset' => [
                    'sourcePath' => null,
                    'css' => [],
                ],
            ]
        ],
        'errorHandler' => [
            'class' => "yii\web\ErrorHandler",
            'errorAction' => '/tutor/default/error',
        ],
    ],
    'params' => $params,
];