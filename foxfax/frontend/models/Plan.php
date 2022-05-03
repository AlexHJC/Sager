<?php

namespace frontend\models;

/**
 * This is the model class for table "lic_plan".
 *
 * @property integer        $id
 * @property string         $plan_title
 * @property double         $plan_price_year
 * @property double         $plan_price_month
 * @property integer        $plan_doc_limit
 * @property integer        $plan_user_limit
 *
 * @property Subscription[] $subscriptions
 */
class Plan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%plan}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plan_title'], 'required'],
            [['plan_price_year', 'plan_price_month'], 'number'],
            [['plan_doc_limit', 'plan_user_limit'], 'integer'],
            [['plan_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'               => 'ID',
            'plan_slug'        => 'Plan Slug',
            'plan_title'       => 'Plan Title',
            'plan_price_year'  => 'Plan Price Year',
            'plan_price_month' => 'Plan Price Month',
            'plan_doc_limit'   => 'Plan Doc Limit',
            'plan_user_limit'  => 'Plan Users Limit',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptions()
    {
        return $this->hasMany(Subscription::className(), ['plan_id' => 'id']);
    }
}
