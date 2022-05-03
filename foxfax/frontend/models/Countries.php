<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%countries}}".
 *
 * @property integer $id
 * @property string  $title
 * @property integer $code
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%countries}}';
    }

    public static function find()
    {
        return new CountriesQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'title_en', 'title_fr'], 'required'],
            [['title_en', 'title_fr'], 'string', 'max' => 50],
            [['code'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => Yii::t('form', 'ID'),
            'title_en' => Yii::t('form', 'Title EN'),
            'title_fr' => Yii::t('form', 'Title FR'),
            'code'     => Yii::t('form', 'Code'),
        ];
    }

    /**
     * @inheritdoc
     * @return CountriesQuery the active query used by this AR class.
     */

    public function getTitle()
    {
        return $this->{'title_' . Yii::$app->language};
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }
}
