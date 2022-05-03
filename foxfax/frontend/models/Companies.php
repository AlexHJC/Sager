<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%companies}}".
 *
 * @property integer $id
 * @property string  $title
 * @property string  $adress
 * @property string  $phone
 * @property string  $email
 * @property integer $account_id
 * @property string  $description
 * @property string  $sender_name
 * @property string  $sender_email
 * @property integer $alert_email
 * @property integer $alert_sms
 * @property integer $alert_default
 * @property integer $country_id
 * @property string  $sms_time
 * @property integer $shared
 * @property string  $date_added
 * @property integer $last_modify
 */
class Companies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%companies}}';
    }

    public static function find()
    {
        return new CompaniesQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_en', 'title_fr', 'email', 'adress', 'sender_name'], 'required'],
            [['adress', 'description'], 'string'],
            // [['phone'], ],
            ['phone', 'match', 'pattern' => '/^[(999)-999-9999]+$/', 'message' => Yii::t('form', 'Invalid phone number')],
            [['alert_email', 'alert_sms', 'alert_default', 'account_id', 'country_id', 'shared'], 'integer'],
            [['sms_time', 'date_added', 'last_modify'], 'safe'],
            [['title_en', 'title_fr'], 'string', 'max' => 255],
            [['email', 'sender_email', 'locale'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('form', 'ID'),
            'title_en'      => Yii::t('form', 'Company name'),
            'title_fr'      => Yii::t('form', 'Title FR'),
            'adress'        => Yii::t('form', 'Address'),
            'phone'         => Yii::t('form', 'Phone'),
            'locale'        => Yii::t('form', 'Notification Language'),
            'email'         => Yii::t('form', 'Email'),
            'description'   => Yii::t('form', 'Description'),
            'sender_name'   => Yii::t('form', 'Contact Name'),
            'sender_email'  => Yii::t('form', 'Sender Email'),
            'alert_email'   => Yii::t('form', 'Alert Email'),
            'alert_sms'     => Yii::t('form', 'Alert Sms'),
            'alert_default' => Yii::t('form', 'Alert Default'),
            'country_id'    => Yii::t('form', 'Country'),
            'account_id'    => Yii::t('form', 'Account'),
            'sms_time'      => Yii::t('form', 'Sms Time'),
            'shared'        => Yii::t('form', 'Shared'),
            'date_added'    => Yii::t('form', 'Date Added'),
            'last_modify'   => Yii::t('form', 'Last Modify'),
        ];
    }

    /**
     * @inheritdoc
     * @return CompaniesQuery the active query used by this AR class.
     */

    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['id' => 'country_id']);
    }

    public function getCountryName()
    {
        return $this->country->title;
    }

    public function getAccount()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'account_id']); // Select where User->id = ThisModel->client_id
    }

    public function getAccountName()
    {
        return $this->user['username'];
    }

    public function getTitle()
    {
        return $this->{'title_' . Yii::$app->language};
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function checkBeforeRegistration()
    {
        if ($this->validate(['title_en', 'country_id', 'adress'])) {

            return true;
        }

        return false;
    }
}
