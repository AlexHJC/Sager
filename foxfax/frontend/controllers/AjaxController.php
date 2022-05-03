<?php

namespace frontend\controllers;

use common\components\filters\AjaxFilter;
use frontend\models\Alerts;
use frontend\models\AlertsSearch;
use frontend\models\CertificatesTypes;
use frontend\models\CertificatesTypesItems;
use frontend\models\Cities;
use frontend\models\Labels;
use frontend\models\Notifications;
use frontend\models\Periods;
use frontend\models\States;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * AlertsController implements the CRUD actions for Alerts model.
 */
class AjaxController extends BaseController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['get-states', 'get-cities'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'states' => ['get', 'post']
                ]
            ]
        ];
    }

    public function actionGetStates()
    {

        $cId =(!empty($_GET['id'])) ? (int)$_GET['id'] : 0;
        if($cId > 0) {
            $states = States::find()->where(['country_id' => $cId])->all();

            foreach($states as $state ){
                echo "<option value='" . $state->id . "'>".$state->title_en."</option>";
            }
        }


    }

    public function actionGetCities()
    {
        $sId = (!empty($_GET['id'])) ? (int)$_GET['id'] : 0;

        if($sId > 0){
            $cities = Cities::find()->where(array('state_id' => $sId))->all();

            foreach($cities as $city){
                echo "<option value='" . $city->id . "'>".$city->title_en."</option>";
            }
        }
    }
}
