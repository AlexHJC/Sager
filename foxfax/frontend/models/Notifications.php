<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%notifications}}".
 *
 * @property integer $id
 * @property string  $title
 * @property string  $subject
 * @property string  $text
 * @property string  $added
 * @property string  $modified
 * @property integer $modified_by
 * @property integer $account_id
 * @property integer $position
 * @property string  $status
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notifications}}';
    }

    /**
     * @inheritdoc
     * @return NotificationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotificationsQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_en', 'title_fr', 'subject_en', 'subject_fr'], 'required'],
            [['text_en', 'text_fr'], 'string'],
            [['added', 'modified'], 'safe'],
            [['modified_by', 'position'], 'integer'],
            [['title_en', 'title_fr', 'subject_en', 'subject_fr'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('form', 'ID'),
            'title_en'    => Yii::t('form', 'Title EN'),
            'title_fr'    => Yii::t('form', 'Title FR'),
            'subject_en'  => Yii::t('form', 'Subject EN'),
            'subject_fr'  => Yii::t('form', 'Subject FR'),
            'text_en'     => Yii::t('form', 'Text EN'),
            'text_fr'     => Yii::t('form', 'Text FR'),
            'added'       => Yii::t('form', 'Added'),
            'modified'    => Yii::t('form', 'Modified'),
            'modified_by' => Yii::t('form', 'Modified By'),
            'position'    => Yii::t('form', 'Position'),
            'status'      => Yii::t('form', 'Status'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'modified_by']); // Select where User->id = ThisModel->client_id
    }

    public function getUserName()
    {
        return $this->user->username;
    }

    public function getTitle()
    {
        return $this->{'title_' . Yii::$app->language};
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getSubject()
    {
        return $this->{'subject_' . Yii::$app->language};
    }

    public function setSubject($value)
    {
        $this->subject = $value;
    }

    public function getText()
    {
        return $this->{'text_' . Yii::$app->language};
    }

    public function setText($value)
    {
        $this->text = $value;
    }
}
