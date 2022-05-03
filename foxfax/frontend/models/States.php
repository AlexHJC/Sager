<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "lic_states".
 *
 * @property integer $id
 * @property string $title_en
 * @property string $title_fr
 * @property integer $country_id
 */
class States extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%states}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_en', 'title_fr'], 'required'],
            [['country_id'], 'integer'],
            [['title_en', 'title_fr'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_en' => 'Title En',
            'title_fr' => 'Title Fr',
            'country_id' => 'Country ID',
        ];
    }

    /**
     * @inheritdoc
     * @return StatesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StatesQuery(get_called_class());
    }
}
