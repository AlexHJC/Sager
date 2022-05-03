<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%certificates_types_items}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string  $title_en
 * @property string  $title_fr
 * @property string  $status
 * @property integer $position
 */
class CertificatesTypesItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%certificates_types_items}}';
    }

    public static function find()
    {
        return new CertificatesTypesItemsQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_en', 'title_fr'], 'required'],
            [['parent_id', 'position'], 'integer'],
            [['title_en', 'title_fr'], 'string', 'max' => 255],
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
            'parent_id' => Yii::t('form', 'Parent ID'),
            'title_en'  => Yii::t('form', 'Title En'),
            'title_fr'  => Yii::t('form', 'Title Fr'),
            'status'    => Yii::t('form', 'Status'),
            'position'  => Yii::t('form', 'Position'),
        ];
    }

    /**
     * @inheritdoc
     * @return CertificatesTypesItemsQuery the active query used by this AR class.
     */


    public function getTitle()
    {
        return $this->{'title_' . Yii::$app->language};
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getType()
    {
        return $this->hasOne(CertificatesTypes::className(), ['id' => 'parent_id']);
    }

    public function getCertificateType()
    {
        return $this->hasOne(CertificatesTypes::className(), ['id' => 'parent_id']);
    }

    public function getTypeName()
    {
        return $this->type['title'];
    }
}
