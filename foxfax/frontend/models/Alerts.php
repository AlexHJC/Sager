<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%alerts}}".
 *
 * @property integer $id
 * @property integer $certificat_id
 * @property integer $label_id
 * @property integer $notification_id
 * @property integer $period_id
 * @property integer $position
 */
class Alerts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%alerts}}';
    }

    /**
     * @inheritdoc
     * @return AlertsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlertsQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['certificat_id', 'label_id', 'notification_id', 'period_id', 'position'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'              => Yii::t('form', 'ID'),
            'certificat_id'   => Yii::t('form', 'Certificat ID'),
            'label_id'        => Yii::t('form', 'Label ID'),
            'notification_id' => Yii::t('form', 'Notification ID'),
            'period_id'       => Yii::t('form', 'Period ID'),
            'position'        => Yii::t('form', 'Position'),
            'title'           => Yii::t('form', 'Title'),
        ];
    }

    public function getCertificat()
    {
        return $this->hasOne(CertificatesTypesItems::className(), ['id' => 'certificat_id']);
    }

    public function getCertificatName()
    {
        return $this->certificat['title'];
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

    public function getPeriod()
    {
        return $this->hasOne(Periods::className(), ['id' => 'period_id']);
    }

    public function getPeriodName()
    {
        return $this->period['title'];
    }

    public function getTitle()
    {
        return $this->{'title_' . Yii::$app->language};
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }
}
