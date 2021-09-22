<?php


namespace frontend\assets;

use yii\web\AssetBundle;

class AdminLte3Asset extends AssetBundle
{

    public $css = [
        'base-assets/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
        'custom.css',
    ];

    public $baseUrl = '@homeUrl/template/adminlte3/';

    public $js = [
        'base-assets/sweetalert2/sweetalert2.min.js',
        'base-assets/chart.js/Chart.min.js',
        'base-assets/js/adminlte.min.js',
        'base-assets/js/demo.js',
        'custom.js'
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\YiiAsset',
    ];

}
