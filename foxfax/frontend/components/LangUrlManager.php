<?php

namespace frontend\components;

use Yii;
use yii\web\UrlManager;

// use frontend\models\Lang;

class LangUrlManager extends UrlManager
{
    public function createUrl($params)
    { // Yii::$app->language
        if (isset($params['locale'])) {
            if (array_key_exists($params['locale'], Yii::$app->params['availableLocales'])) {
                $lang = $params['locale'];
            } else {
                $lang = Yii::$app->language;
            }
            unset($params['locale']);
        } else {
            $lang = Yii::$app->language;
        }
        // var_dump($lang);
        $url = parent::createUrl($params);

        if ($url == '/') {
            return '/' . $lang;
        } else {
            return '/' . $lang . $url;
        }

    }
}