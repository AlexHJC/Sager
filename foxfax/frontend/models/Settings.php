<?php

namespace frontend\models;

/**
 * This is the model class for table "lic_settings".
 *
 * @property integer $id
 * @property string  $section
 * @property string  $settings_key
 * @property string  $settings_value
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section', 'settings_key', 'settings_value'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'section'        => 'Section',
            'settings_key'   => 'Key',
            'settings_value' => 'Value',
        ];
    }

    public function getSetting($sKey)
    {
        $oSetting = self::find()->where(array('settings_key' => $sKey))->one();

        return $oSetting->settings_value;
    }

    /**
     * @inheritdoc
     * @return SettingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SettingsQuery(get_called_class());
    }
}
