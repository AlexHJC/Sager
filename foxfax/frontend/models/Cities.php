<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "lic_cities".
 *
 * @property integer $id
 * @property string $title_en
 * @property string $title_fr
 * @property integer $state_id
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lic_cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_en', 'title_fr', 'state_id'], 'required'],
            [['state_id'], 'integer'],
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
            'state_id' => 'State ID',
        ];
    }

    /**
     * @inheritdoc
     * @return CitiesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CitiesQuery(get_called_class());
    }
}
