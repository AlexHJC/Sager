<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%certificates_types}}".
 *
 * @property integer $id
 * @property integer $title
 * @property string  $status
 * @property integer $position
 */
class CertificatesTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%certificates_types}}';
    }

    public static function find()
    {
        return new CertificatesTypesQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_en', 'title_fr'], 'required'],
            [['title_en', 'title_fr'], 'string', 'max' => 255],
            [['position', 'parent_id'], 'integer'],
            [['status'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => Yii::t('form', 'ID'),
            'parent_id' => Yii::t('form', 'Parent Category'),
            'title_en'  => Yii::t('form', 'Title EN'),
            'title_fr'  => Yii::t('form', 'Title FR'),
            'status'    => Yii::t('form', 'Status'),
            'position'  => Yii::t('form', 'Position'),
        ];
    }

    /**
     * @inheritdoc
     * @return CertificatesTypesQuery the active query used by this AR class.
     */

    public function getTitle()
    {
        return $this->{'title_' . Yii::$app->language};
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getItems() 
    {
        return $this->hasMany(CertificatesTypesItems::className(), ['parent_id' => 'id']);
    }
    public function getItemsActive() 
    {
        return $this->hasMany(CertificatesTypesItems::className(), ['parent_id' => 'id'])->where(['status' =>'active']);
    }
}
