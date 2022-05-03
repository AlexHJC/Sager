<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%certificates_attach}}".
 *
 * @property integer $id
 * @property integer $certificat_id
 * @property string  $file
 */
class CertificatesAttach extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%certificates_attach}}';
    }

    /**
     * @inheritdoc
     * @return CertificatesAttachQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CertificatesAttachQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['certificat_id'], 'integer'],
            [['file'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('form', 'ID'),
            'certificat_id' => Yii::t('form', 'Certificat ID'),
            'file'          => Yii::t('form', 'File'),
        ];
    }
}
