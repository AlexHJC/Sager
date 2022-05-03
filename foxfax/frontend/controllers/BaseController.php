<?php
/**
 * Created by PhpStorm.
 * Users: art
 * Date: 11/6/17
 * Time: 11:42 PM
 */

namespace frontend\controllers;


use frontend\models\Certificates;
use frontend\models\Reminders;
use frontend\models\Settings;
use frontend\models\Subscription;
use frontend\models\Users;
use Yii;
use yii\db\Expression;
use yii\web\Controller;

class BaseController extends Controller
{

    public $nDocActive  = 0;
    public $nDocExpired = 0;
    public $nAccountId  = 0;
    public $nAccounts   = 0;
    public $bIsAccount  = false;

    public $nReminder = 0;

    public function init()
    {
        $this->nDocActive = 0;
        $this->nReminder = 0;

        if (!empty(Yii::$app->user->identity->id)) {
            $this->nAccountId = (!empty(Yii::$app->user->identity->parent_id)) ? Yii::$app->user->identity->parent_id : Yii::$app->user->identity->id;

            $this->nDocActive = Certificates::find()
                ->where(['>=', 'expire', new Expression('NOW()')])
                ->andWhere(['=', 'account_id', $this->nAccountId])
                ->count('id');

            $this->nDocExpired = Certificates::find()
                ->where(['<', 'expire', new Expression('NOW()')])
                ->andWhere(['=', 'account_id', $this->nAccountId])
                ->count('id');

            $this->nReminder = Reminders::find()
                ->joinWith('certificat')
                ->where(['>', 'date_alert', new Expression('NOW()')])
                ->andWhere(['=', 'account_id', $this->nAccountId])
                ->count('{{%reminders}}.id');
            $this->bIsAccount = (empty(Yii::$app->user->identity->parent_id)) ? true : false;
        }

        $this->view->params['nDocActive'] = $this->nDocActive;
        $this->view->params['nDocExpired'] = $this->nDocExpired;
        $this->view->params['nReminder'] = $this->nReminder;
        $this->view->params['bIsAccount'] = $this->bIsAccount;
        $this->view->params['adminEmail'] = $this->getAdminEmail();
    }

    /**
     * @return string
     */
    public function getAdminEmail()
    {
        $oModelSettings = new Settings();
        $sRobotEmail = $oModelSettings->getSetting('adminEmail');
        return $sRobotEmail;
    }

    /**
     * @return array
     */
    public function getNumberOfRemainUsers()
    {
        $user = Yii::$app->user->identity;
        $nUsers = Users::find()->where(['parent_id' => $user->id])->count('id');
        $subscription = Subscription::find()->where(array('user_id' => $user->id))->with('plan')->one();
        if($subscription) {
            $nPlanUserLimit = isset($subscription->plan->plan_user_limit) ? $subscription->plan->plan_user_limit : 1;
            $nMaxUsers = (!empty($nPlanUserLimit)) ? $subscription->plan->plan_user_limit : 'unlimited';
        }
        else {
            $nMaxUsers = 1;
        }

        if (is_numeric($nMaxUsers)) {
            $nRemainUsers = abs($nMaxUsers - $nUsers);
        } else {
            $nRemainUsers = $nMaxUsers;
        }


        $aResult = array('nUsers' => $nUsers, 'nMaxUsers' => $nMaxUsers, 'nRemain' => $nRemainUsers);

        return $aResult;
    }

    /**
     * @return string
     */
    public function getRobotEmail()
    {
        $oModelSettings = new Settings();
        $sRobotEmail = $oModelSettings->getSetting('robotEmail');
        return $sRobotEmail;
    }


}