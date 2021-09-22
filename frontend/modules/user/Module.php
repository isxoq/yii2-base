<?php

namespace frontend\modules\user;

use Yii;
use soft\helpers\SiteHelper;
use yii\web\ErrorHandler;

/**
 * tutor module definition class
 */
class Module extends \yii\base\Module
{
    public $defaultRoute = 'default/home';
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\user\controllers';

    /**
     * {@inheritdoc}
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if (!user()) {
            forbidden();
        }
        $this->findLayout();

        parent::init();

        $config = require(__DIR__ . '/config/main.php');

        Yii::configure(Yii::$app, $config);

        SiteHelper::setLanguage();

        /** @var ErrorHandler $handler */
        $handler = $this->get('errorHandler');
        Yii::$app->set('errorHandler', $handler);
        $handler->register();
    }

    private function findLayout()
    {
        $this->layoutPath = '@frontend/modules/reception/views/layouts';
    }
}
