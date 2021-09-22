<?php

namespace frontend\modules\chat\controllers;

use frontend\modules\chat\models\Storage;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `chat` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetMessages()
    {
        $storage = new Storage();
        return file_get_contents($storage->fileName);
    }
}
