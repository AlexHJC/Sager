<?php
namespace frontend\components;
use Yii;
use yii\web\UrlManager;
use frontend\components\DMultilangHelper2;

class DLanguageUrlManager extends UrlManager
{
    public function createUrl($route, $params=array(), $ampersand='&')
    {
        $url = parent::createUrl($route, $params, $ampersand);
        return DMultilangHelper2::addLangToUrl($url);
    }
}

?>