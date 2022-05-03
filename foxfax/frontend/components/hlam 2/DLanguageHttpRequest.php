<?php
namespace frontend\components;
use Yii;
use yii\web\Request;
use frontend\components\DMultilangHelper2;

class DLanguageHttpRequest extends Request
{
    private $_requestUri;
 
    public function getRequestUri()
    {
        if ($this->_requestUri === null)
            $this->_requestUri = DMultilangHelper2::processLangInUrl(parent::getRequestUri());
 
        return $this->_requestUri;
    }
 
    public function getOriginalUrl()
    {
        return $this->getOriginalRequestUri();
    }
 
    public function getOriginalRequestUri()
    {
        return DMultilangHelper2::addLangToUrl($this->getRequestUri());
    }
}
?>
