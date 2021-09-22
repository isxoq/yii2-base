<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class VueAsset extends AssetBundle
{

    public $sourcePath = '@frontend/web/packages/vue';

    public $js = [
        'vue.js'
    ];

    public $depends = [
        AxiosAsset::class,
    ];

}