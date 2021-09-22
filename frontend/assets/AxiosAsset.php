<?php


namespace frontend\assets;


use yii\web\AssetBundle;

class AxiosAsset extends AssetBundle
{

    public $sourcePath = '@frontend/web/packages/axios';
    public $js = ['axios.js'];
}