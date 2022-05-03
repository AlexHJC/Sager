<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%certificates}}".
 *
 * @property integer $id
 * @property integer $type_id
 * @property string  $added
 * @property string  $expire
 * @property string  $valable
 * @property string  $attachment
 * @property integer $modify_by
 * @property integer $account_id
 * @property integer $comments
 */
class Certificates2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%certificates}}';
    }

    /**
     * @inheritdoc
     * @return CertificatesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CertificatesQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
     
     
    //[['type_id', 'modify_by', 'product_id', 'company_id', 'parent_id'], 'integer'],
            
    public function rules()
    {
        return [
            [['expire'], 'required'],
            [['type_id', 'modify_by', 'company_id', 'parent_id'], 'integer'],
            [['added', 'expire', 'title_en', 'title_fr'], 'safe'],
            [['valable'], 'string', 'max' => 10],
            [['attachment'], 'string', 'max' => 255],
            [['comments'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('form', 'ID'),
            'title_en'   => Yii::t('form', 'Title EN'),
            'title_fr'   => Yii::t('form', 'Title FR'),
            'product_id' => Yii::t('form', 'Product'),
            'company_id' => Yii::t('form', 'Supplier'),
            'type_id'    => Yii::t('form', 'Category'),
            'parent_id'  => Yii::t('form', 'Category'),
            'added'      => Yii::t('form', 'Added Date'),
            'expire'     => Yii::t('form', 'Expir. Date'),
            'valable'    => Yii::t('form', 'Valable'),
            'attachment' => Yii::t('form', 'Attachment'),
            'modify_by'  => Yii::t('form', 'Modified'),
            'comments'   => Yii::t('form', 'Comments'),
        ];
    }

    public function getType()
    {
        return $this->hasOne(CertificatesTypes::className(), ['id' => 'type_id']);
    }

    public function getTypeName()
    {
        return $this->type['title'];
    }

    public function getParent()
    {
        return $this->hasOne(CertificatesTypesItems::className(), ['id' => 'parent_id']);
    }

    public function getParentName()
    {
        return $this->parent['title'];
    }

    public function getUser()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'modify_by']); // Select where User->id = ThisModel->client_id
    }

    public function getUserName()
    {
        return $this->user['username'];
    }

    public function getTitle()
    {
        return $this->{'title_' . Yii::$app->language};
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }
}
