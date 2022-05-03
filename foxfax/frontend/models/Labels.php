<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%labels}}".
 *
 * @property integer $id
 * @property string  $title
 * @property string  $color
 * @property string  $status
 * @property integer $position
 */
class Labels extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%labels}}';
    }

    /**
     * @inheritdoc
     * @return LabelsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LabelsQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'color'], 'required'],
            [['position'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['color', 'status'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => Yii::t('form', 'ID'),
            'title'    => Yii::t('form', 'Title'),
            'color'    => Yii::t('form', 'Color'),
            'status'   => Yii::t('form', 'Status'),
            'position' => Yii::t('form', 'Position'),
        ];
    }
}
