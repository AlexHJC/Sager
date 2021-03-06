<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'email', 'subject', 'body'], 'required'],
            [['verifyCode'], 'safe'],
            [['name', 'subject', 'body'], 'filter', 'filter' => 'strip_tags'],
            ['email', 'email'],
            // ['verifyCode', 'captcha'],

        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name'       => Yii::t('frontend', 'Name'),
            'email'      => Yii::t('frontend', 'Email'),
            'subject'    => Yii::t('frontend', 'Subject'),
            'body'       => Yii::t('frontend', 'Body'),
            'verifyCode' => Yii::t('frontend', 'Verification Code')
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string $email the target email address
     *
     * @return boolean whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            return Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom($this->getRobotEmail())
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();
        } else {
            echo 'ERROR';
            return false;
        }
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
}
