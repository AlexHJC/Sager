<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property integer $id
 * @property integer $account_id
 * @property integer $company_id
 * @property integer $certificat_id
 * @property string  $cod
 * @property string  $title_en
 * @property string  $title_fr
 * @property string  $lot
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    public static function find()
    {
        return new ProductsQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod', 'title_en', 'title_fr'], 'required'],
            [['company_id', 'certificat_id', 'account_id'], 'integer'],
            [['cod', 'title_en', 'title_fr', 'lot'], 'string', 'max' => 255],
            [['cod'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     * @return ProductsQuery the active query used by this AR class.
     */

    // public function getCompany(){
    //     return $this->hasOne(Companies::className(), ['id' => 'company_id']);
    // }
    // public function getCompanyName() {
    //     return $this->company->title;
    // }
    // public function getCertificat() {
    //     return $this->hasOne(Certificates::className(), ['id' => 'certificat_id']); // Select where User->id = ThisModel->client_id
    // }
    // public function getCertificatName() {
    //     return $this->certificat->title;
    // }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('form', 'ID'),
            'company_id'    => Yii::t('form', 'Company ID'),
            'certificat_id' => Yii::t('form', 'Certificat ID'),
            'cod'           => Yii::t('form', 'Cod'),
            'title_en'      => Yii::t('form', 'Title EN'),
            'title_fr'      => Yii::t('form', 'Title FR'),
            'lot'           => Yii::t('form', 'Lot'),
        ];
    }




    public function getTitle()
    {
        return $this->{'title_' . Yii::$app->language};
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getAccount()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'account_id']); // Select where User->id = ThisModel->client_id
    }

    public function getAccountName()
    {
        return $this->user['username'];
    }
}
