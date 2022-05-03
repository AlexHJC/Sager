<?php

namespace frontend\controllers;

use frontend\models\Certificates;
use frontend\models\ContactForm;
use frontend\models\States;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\VerbFilter;


/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error'      => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha'    => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            'set-locale' => [
                'class'   => 'common\actions\SetLocaleAction',
                'locales' => array_keys(Yii::$app->params['availableLocales'])
            ]
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['states'],
                'rules' => [
                    [
                        'actions' => ['states'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'states' => ['get']
                ]
            ]
        ];
    }

    public function actionIndex()
    {

        


        // $now = new Expression('NOW()');
        $tod = date('Y-m-d');
        $expired = Certificates::find()
            ->where(['=', 'account_id', $this->nAccountId])
            ->andWhere(['<', 'expire', $tod])
            ->count();

        $today = Certificates::find()
            ->where(['=', 'account_id', $this->nAccountId])
            ->andWhere(['=', 'expire', $tod])
            ->count();

        $plus10 = date('Y-m-d', strtotime("+10 days"));
        $expire10 = Certificates::find()
            ->where(['=', 'account_id', $this->nAccountId])
            ->andWhere(['>', 'expire', $tod])
            ->andWhere(['<', 'expire', $plus10])
            ->count();

        $plus30 = date('Y-m-d', strtotime("+30 days"));
        $expire30 = Certificates::find()
            ->where(['=', 'account_id', $this->nAccountId])
            ->andWhere(['>', 'expire', $tod])
            ->andWhere(['<', 'expire', $plus30])
            ->count();


        $month = Certificates::find()
            ->where(['=', 'account_id', $this->nAccountId])
            ->andWhere(['>', 'expire', $tod])
            ->andWhere(['<', 'expire', $plus30])
            ->count();


        $last10doc = Certificates::find()
            ->where(['=', 'account_id', $this->nAccountId])
            ->andWhere(['<', 'expire', date('Y-m-d')])
            // ->orderBy('added DESC')
            ->limit(10)
            ->all();


        $next20 = Certificates::find()
            ->where(['=', 'account_id', $this->nAccountId])
            ->andWhere(['>', 'expire', $tod])
            ->limit(20)
            ->all();

        // $xx = new Expression('NOW()');
        // var_dump($xx);

        // $expired = Certificates::find()
        //     ->where(['<', 'expire', new Expression('NOW()')])
        //     ->andwhere(['>', 'expire', new Expression('NOW()')])
        //     ->count();  


        return $this->render('index',
            array(
                'expired'   => $expired,
                'today'     => $today,
                'expire10'  => $expire10,
                'expire30'  => $expire30,
                'last10doc' => $last10doc,
                'next20'    => $next20,
            )
        );
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->contact($this->getAdminEmail())) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body'    => Yii::t('frontend', 'Thank you for contacting us. We will respond to you as soon as possible.'),
                    'options' => ['class' => 'alert-success']
                ]);
                return $this->refresh();
            } else {
                Yii::$app->getSession()->setFlash('alert', [
                    'body'    => \Yii::t('frontend', 'There was an error sending email.'),
                    'options' => ['class' => 'alert-danger']
                ]);
            }
        }

        return $this->render('contact', [
            'model' => $model
        ]);
    }


}
