<?php

namespace frontend\controllers;

use frontend\models\ContactForm;
use Yii;

/**
 * Cabinet controller
 */
class CabinetController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function __construct($id, $module, $config = array())
    {
        parent::__construct($id, $module, $config);
        $this->layout = 'adminlayout';
    }

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

    public function actionIndex()
    {

        return $this->render('index');
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


    public function actionSuper()
    {
        return $this->render('super');
    }

    public function actionSuper2()
    {
        return $this->render('super2');
    }

    public function actionText()
    {
        return $this->render('text');
    }

    public function actionTest()
    {
        return $this->render('test');
    }

    public function actionZilazi()
    {
        return $this->render('zilazi');
    }

    public function actionZilazi2()
    {
        return $this->render('zilazi2');
    }

    public function actionBravo()
    {
        return $this->render('bravo');
    }

    public function actionAwesome()
    {
        return $this->render('awesome');
    }

    public function actionFormula2()
    {
        return $this->render('formula2');
    }

    public function actionFormula3()
    {
        return $this->render('formula3');
    }

    public function actionEx1()
    {
        return $this->render('ex1');
    }

    public function actionSuport()
    {
        return $this->render('suport');
    }
}
