<?php

namespace frontend\models;

/**
 * This is the model class for table "lic_payments".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $plan_id
 * @property integer $payment_cycle
 * @property integer $payer_id
 * @property string  $payment_id
 * @property string  $payment_state
 * @property double  $payment_amount
 * @property string  $payment_currency
 * @property string  $payment_method
 * @property string  $invoice_number
 * @property string  $status
 * @property string  $payer_email
 * @property string  $payer_first_name
 * @property string  $payer_last_name
 * @property string  $payer_phone
 * @property string  $payer_country_code
 *
 * @property Users   $user
 */
class Payments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payments}}';
    }

    /**
     * @inheritdoc
     * @return PaymentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PaymentsQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'payment_id', 'payment_state', 'payment_method'], 'required'],
            [['user_id', 'plan_id'], 'integer'],
            [['payment_amount'], 'number'],
            [['payment_id', 'payment_method', 'payer_id', 'payment_cycle'], 'string', 'max' => 255],
            [['payment_state', 'invoice_number', 'status'], 'string', 'max' => 20],
            [['payment_currency'], 'string', 'max' => 3],
            [['payer_email'], 'string', 'max' => 60],
            [['payer_first_name', 'payer_last_name', 'payer_phone'], 'string', 'max' => 40],
            [['payer_country_code'], 'string', 'max' => 2],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                 => 'ID',
            'user_id'            => 'Users ID',
            'plan_id'            => 'Plan ID',
            'payer_id'           => 'Payer ID',
            'payment_cycle'      => 'Payment Cycle',
            'payment_id'         => 'Payment ID',
            'payment_state'      => 'Payment State',
            'payment_amount'     => 'Payment Amount',
            'payment_currency'   => 'Payment Currency',
            'payment_method'     => 'Payment Method',
            'invoice_number'     => 'Invoice Number',
            'status'             => 'Status',
            'payer_email'        => 'Payer Email',
            'payer_first_name'   => 'Payer First Name',
            'payer_last_name'    => 'Payer Last Name',
            'payer_phone'        => 'Payer Phone',
            'payer_country_code' => 'Payer Country Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(Plan::className(), ['id' => 'plan_id']);
    }

}
