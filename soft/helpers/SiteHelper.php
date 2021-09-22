<?php

namespace soft\helpers;

use Yii;
/**
 * Class SiteHelper
 * Saytda ishlatish ba'zi funksiyalar
 * @package soft\components
 */

class SiteHelper
{

    public static function setLanguage()
    {
        $params = Yii::$app->params;
        $lang = Yii::$app->request->get($params['languageParam'], $params['defaultLanguage'] );
        if (!array_key_exists($lang, $params['languages'])){
            $lang = $params['defaultLanguage'];
        }
        Yii::$app->language = $lang;
    }
    
    /**
     * Sistemani aniqlash
     * @return string
     */
    public static function getOsName()
    {
        return strtoupper(substr(PHP_OS, 0, 3));
    }


     public static function userDefaultAvatar()
    {
        return "/images/user-default-avatar.png";
    }

}


?>