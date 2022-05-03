<?php

namespace common\commands;


use yii\base\Object;
use yii\swiftmailer\Message;
use trntv\bus\interfaces\SelfHandlingCommand;
use frontend\models\Settings;
use Swift_SmtpTransport;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 *
 * @property string $smtpUser
 * @property string $smtpHost
 * @property string $smtpPort
 * @property string $smtpPass
 * @property string $smtpEncryption
 * @property string $robotEmail
 */
class SendEmailCommand extends Object implements SelfHandlingCommand
{
    /**
     * @var mixed
     */
    public $from;
    /**
     * @var mixed
     */
    public $to;
    /**
     * @var string
     */
    public $subject;
    /**
     * @var string
     */
    public $view;
    /**
     * @var array
     */
    public $params;
    /**
     * @var string
     */
    public $body;
    /**
     * @var bool
     */
    public $html = true;

    /**
     * Command init
     */
    public function init()
    {
        $transport = new Swift_SmtpTransport($this->getSmtpHost(), $this->getSmtpPort(), $this->getSmtpEncryption());
        $transport->setUsername($this->getSmtpUser());
        $transport->setPassword($this->getSmtpPass());

        $this->from = $this->from ?: $this->getRobotEmail();
    }

    /**
     * @return string
     */
    public function getSmtpHost()
    {
        $oModelSettings = new Settings();
        $smtpHost = $oModelSettings->getSetting('smtpHost');
        return $smtpHost;

    }

    /**
     * @return string
     */
    public function getSmtpPort()
    {
        $oModelSettings = new Settings();
        $smtpPort = $oModelSettings->getSetting('smtpPort');
        return $smtpPort;
    }

    /**
     * @return string
     */
    public function getSmtpEncryption()
    {
        $oModelSettings = new Settings();
        $smtpEncryption = $oModelSettings->getSetting('smtpEncryption');
        return $smtpEncryption;
    }

    /**
     * @return string
     */
    public function getSmtpUser()
    {
        $oModelSettings = new Settings();
        $smtpUser = $oModelSettings->getSetting('smtpUser');
        return $smtpUser;
    }

    /**
     * @return string
     */
    public function getSmtpPass()
    {
        $oModelSettings = new Settings();
        $smtpPass = $oModelSettings->getSetting('smtpPass');
        return $smtpPass;
    }

    /**
     * @return string
     */
    public function getRobotEmail()
    {
        $oModelSettings = new Settings();
        $sRobotEmail = $oModelSettings->getSetting('robotEmail');
        return $sRobotEmail;
    }

    /**
     * @param \common\commands\SendEmailCommand $command
     * @return bool
     */
    public function handle($command)
    {
        if (!$command->body) {
            $message = \Yii::$app->mailer->compose($command->view, $command->params);
        } else {
            $message = new Message();
            if ($command->isHtml()) {
                $message->setHtmlBody($command->body);
            } else {
                $message->setTextBody($command->body);
            }
        }
        $message->setFrom($command->from);
        $message->setTo($command->to ?: $this->getRobotEmail());
        $message->setSubject($command->subject);
        return $message->send();
    }

    /**
     * @return bool
     */
    public function isHtml()
    {
        return (bool)$this->html;
    }
}
