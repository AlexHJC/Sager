<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%reminders}}".
 *
 * @property integer $id
 * @property integer $certificat_id
 * @property integer $product_id
 * @property integer $company_id
 * @property integer $certificat_type
 * @property string  $date_alert
 * @property string  $status
 * @property string  $state
 * @property string  $comment
 */
class Reminders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%reminders}}';
    }

    public static function find()
    {
        return new RemindersQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_alert'], 'required'],
            [['certificat_id', 'product_id', 'company_id', 'certificat_type', 'days', 'label_id', 'notification_id', 'alert_id'], 'integer'],
            [['date_alert', 'expire', 'last_send'], 'safe'],
            [['comment'], 'string'],
            [['status', 'state', 'group'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'              => Yii::t('form', 'ID'),
            'certificat_id'   => Yii::t('form', 'Certificat'),
            'product_id'      => Yii::t('form', 'Product'),
            'company_id'      => Yii::t('form', 'Company'),
            'label_id'        => Yii::t('form', 'Label'),
            'days'            => Yii::t('form', 'Days left'),
            'last_send'       => Yii::t('form', 'Last send'),
            'expire'          => Yii::t('form', 'Expire on'),
            'certificat_type' => Yii::t('form', 'Certificat Type'),
            'date_alert'      => Yii::t('form', 'Date Alert'),
            'status'          => Yii::t('form', 'Status'),
            'state'           => Yii::t('form', 'State'),
            'comment'         => Yii::t('form', 'Comment'),
            'group'           => Yii::t('form', 'Is Group'),
            'notification_id' => Yii::t('form', 'Notification'),
            'alert_id'        => Yii::t('form', 'Alert'),
        ];
    }

    /**
     * @inheritdoc
     * @return RemindersQuery the active query used by this AR class.
     */

    public function getCertificat()
    {
        return $this->hasOne(Certificates::className(), ['id' => 'certificat_id']);
    }

    public function getCertificatName()
    {
        return $this->certificat['title'];
    }

    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }

    public function getProductName()
    {
        return $this->product['title'];
    }

    public function getCompany()
    {
        return $this->hasOne(Companies::className(), ['id' => 'company_id']);
    }

    public function getCompanyName()
    {
        return $this->company['title'];
    }

    public function getType()
    {
        return $this->hasOne(CertificatesTypesItems::className(), ['id' => 'certificat_type']);
    }

    public function getTypeName()
    {
        return $this->type['title'];
    }

    public function getLabel()
    {
        return $this->hasOne(Labels::className(), ['id' => 'label_id']);
    }

    public function getLabelName()
    {
        return $this->label['title'];
    }

    public function getNotification()
    {
        return $this->hasOne(Notifications::className(), ['id' => 'notification_id']);
    }

    public function getNotificationName()
    {
        return $this->notification['title'];
    }

    public function getAlert()
    {
        return $this->hasOne(Alerts::className(), ['id' => 'alert_id']);
    }
}
