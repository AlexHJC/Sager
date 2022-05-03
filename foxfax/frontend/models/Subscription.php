<?php

namespace frontend\models;

/**
 * This is the model class for table "lic_subscription".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $plan_id
 * @property string  $plan_cycle
 * @property integer $purchased_at
 * @property integer $start_at
 * @property integer $end_at
 *
 * @property Plan    $plan
 * @property Users   $user
 */
class Subscription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subscription}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'plan_id', 'purchased_at'], 'required'],
            [['user_id', 'plan_id', 'purchased_at', 'start_at', 'end_at'], 'integer'],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['plan_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'user_id'      => 'Users ID',
            'plan_id'      => 'Plan ID',
            'plan_cycle'   => 'Plan Cycle',
            'purchased_at' => 'Purchased At',
            'start_at'     => 'Start At',
            'end_at'       => 'End At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(Plan::className(), ['id' => 'plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }


    /**
     * @param $nUserId
     * @param $nPlanId
     * @param $sPeriod
     *
     * @return bool
     */
    public function updateSubscription($nUserId, $nPlanId, $sPeriod)
    {
        if (is_numeric($nUserId)
            && is_numeric($nPlanId)
            && in_array($sPeriod, array('month', 'year'))) {
            $nPurchasedDate = time();

            $oSubscription = self::find()->where(array('user_id' => $nUserId))->one();
            $nEnd = ($sPeriod == 'month') ? strtotime("+1 month") : strtotime("+1 year");

            if (!empty($oSubscription)) {
                $this->id = $oSubscription->id;
                $nEndAt = $oSubscription->end_at;

                if ($nEndAt > $nPurchasedDate) {
                    $nEnd = ($sPeriod == 'month') ? strtotime("+1 month", $nEndAt) : strtotime("+1 year", $nEndAt);
                }

                $oSubscription->user_id = $nUserId;
                $oSubscription->plan_id = $nPlanId;
                $oSubscription->plan_cycle = $sPeriod;
                $oSubscription->purchased_at = $nPurchasedDate;
                $oSubscription->end_at = $nEnd;
                return $oSubscription->save();

            } else {
                $this->start_at = time();
                $this->user_id = $nUserId;
                $this->plan_id = $nPlanId;
                $this->plan_cycle = $sPeriod;
                $this->purchased_at = $nPurchasedDate;
                $this->end_at = $nEnd;
                return $this->save();
            }

        }

        return false;
    }

}
