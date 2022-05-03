<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%periods}}".
 *
 * @property integer $id
 * @property string  $title
 * @property integer $days
 */
class Periods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%periods}}';
    }

    /**
     * @inheritdoc
     * @return PeriodsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PeriodsQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['days', 'title'], 'required'],
            [['days', 'position'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'    => Yii::t('form', 'ID'),
            'title' => Yii::t('form', 'Title'),
            'days'  => Yii::t('form', 'Days'),
        ];
    }
}
