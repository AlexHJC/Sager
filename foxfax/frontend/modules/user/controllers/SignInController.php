<?php

namespace frontend\modules\user\controllers;

use common\commands\SendEmailCommand;
use common\models\User;
use common\models\UserToken;
use frontend\controllers\BaseController;
use frontend\models\Cities;
use frontend\models\Companies;
use frontend\models\Countries;
use frontend\models\Plan;
use frontend\models\States;
use frontend\modules\user\models\LoginForm;
use frontend\modules\user\models\PasswordResetRequestForm;
use frontend\modules\user\models\ResetPasswordForm;
use frontend\modules\user\models\SignupForm;
use PHPUnit\Framework\Constraint\Count;
use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class SignInController
 *
 * @package frontend\modules\user\controllers
 * @author  Eugene Terentev <eugene@terentev.net>
 */
class SignInController extends BaseController
{

    /**
     * @return array
     */
    public function beforeAction($action)
    {
        $this->layout = "loginlayout";
        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'oauth' => [
                'class'           => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successOAuthCallback']
            ]
        ];
    }


    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'signup', 'login', 'request-password-reset', 'reset-password', 'oauth', 'activation'
                        ],
                        'allow'   => true,
                        'roles'   => ['?']
                    ],
                    [
                        'actions' => [
                            'cron'
                        ],
                        'allow'   => true,
                        'roles'   => ['?']
                    ],
                    [
                        'actions' => [
                            'cron'
                        ],
                        'allow'   => true,
                        'roles'   => ['@']
                    ],
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ]
                ]
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post']
                ]
            ]
        ];
    }

    /**
     * @param int $cId
     */
    public function actionStates($cId)
    {
       $cId =(int) $cId;
       echo $cId;
        if($cId > 0) {
            $states = States::findAll('country_id=' . $cId);
        }


        foreach($states as $value=>$state_name ){
            echo "<option value='".$value."'>".$state_name."</option>";
        }
    }

    /**
     * @return array|string|Response
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if (Yii::$app->request->isAjax) {
            $model->load($_POST);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $old_lang = Yii::$app->language;

            if (isset(Yii::$app->user->identity->id)) {
                $curent_user = \common\models\UserProfile::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
                if (isset($curent_user) && array_key_exists($curent_user->locale, Yii::$app->params['availableLocales'])) {
                    \Yii::$app->language = $curent_user->locale;
                    if ($old_lang != Yii::$app->language) {
                        return $this->redirect('/' . Yii::$app->language);
                    }
                }
            }
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model
            ]);
        }
    }


    public function actionCron()
    {
        $this->layout = "emptylayout";
        return $this->render('cron', [
            // 'model' => $model
        ]);

    }

    /**
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * @return string|Response
     */


    public function actionSignup()
    {

        $model = new SignupForm();
        $plan = Plan::find()->where(array('plan_price_year' => 0, 'plan_price_month' => 0))->one();
        $oDefaultCountry = Countries::find()->where(array('is_default' => 1))->one();
        $nDefaultCountryId = $oDefaultCountry->id;
        $countries = ArrayHelper::map(
            Countries::find()
                ->select(['id', 'title_en', 'is_default'])
                ->asArray()
                ->orderBy('title_en ASC')
                ->all(),
            'id', 'title_en'
        );

        $states = ArrayHelper::map(
            States::find()
                ->select(['id', 'title_en'])
                ->where(['country_id' => $nDefaultCountryId])
                ->asArray()
                ->orderBy('title_en ASC')
                ->all(),
            'id', 'title_en'
        );


        if($model->load(Yii::$app->request->post())){
            $user = $model->registerUser();
            if ($user) {
                if ($model->shouldBeActivated()) {
                    Yii::$app->getSession()->setFlash('alert', [
                        'body'    => Yii::t(
                            'frontend',
                            'Your account has been successfully created. Check your email for further instructions.'
                        ),
                        'options' => ['class' => 'alert-success']
                    ]);
                    Yii::$app->getSession()->setFlash('success', "Your account has been successfully created. Please login to continue");
                } else {
                    Yii::$app->getUser()->login($user);
                }
                return $this->goHome();
            }
        }

       /* if ($model->load(Yii::$app->request->post())) {
            $oCompanyModel->load(Yii::$app->request->post());

            if($oCompanyModel->checkBeforeRegistration()){
                $user = $model->signup();
                if ($user) {
                    if ($model->shouldBeActivated()) {
                        Yii::$app->getSession()->setFlash('alert', [
                            'body'    => Yii::t(
                                'frontend',
                                'Your account has been successfully created. Check your email for further instructions.'
                            ),
                            'options' => ['class' => 'alert-success']
                        ]);
                    } else {
                        Yii::$app->getUser()->login($user);
                    }
                    return $this->goHome();
                }
            }


        }
        */

        return $this->render('signup', [
            'model'     => $model,
            'countries' => $countries,
            'plan' => $plan,
            'states' => $states,
            'nDefaultCountryId' => $nDefaultCountryId,
        ]);
    }


    public function actionActivation($token)
    {
        $token = UserToken::find()
            ->byType(UserToken::TYPE_ACTIVATION)
            ->byToken($token)
            ->notExpired()
            ->one();

        if (!$token) {
            throw new BadRequestHttpException;
        }

        $user = $token->user;
        $user->updateAttributes([
            'status' => User::STATUS_ACTIVE
        ]);
        $token->delete();
        Yii::$app->getUser()->login($user);
        Yii::$app->getSession()->setFlash('alert', [
            'body'    => Yii::t('frontend', 'Your account has been successfully activated.'),
            'options' => ['class' => 'alert-success']
        ]);

        return $this->goHome();
    }

    /**
     * @return string|Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body'    => Yii::t('frontend', 'Check your email for further instructions.'),
                    'options' => ['class' => 'alert-success']
                ]);

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('alert', [
                    'body'    => Yii::t('frontend', 'Sorry, we are unable to reset password for email provided.'),
                    'options' => ['class' => 'alert-danger']
                ]);
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * @param $token
     *
     * @return string|Response
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        }
        catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('alert', [
                'body'    => Yii::t('frontend', 'New password was saved.'),
                'options' => ['class' => 'alert-success']
            ]);
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * @param $client \yii\authclient\BaseClient
     *
     * @return bool
     * @throws Exception
     */
    public function successOAuthCallback($client)
    {
        // use BaseClient::normalizeUserAttributeMap to provide consistency for user attribute`s names
        $attributes = $client->getUserAttributes();
        $user = User::find()->where([
            'oauth_client'         => $client->getName(),
            'oauth_client_user_id' => ArrayHelper::getValue($attributes, 'id')
        ])
            ->one();
        if (!$user) {
            $user = new User();
            $user->scenario = 'oauth_create';
            $user->username = ArrayHelper::getValue($attributes, 'login');
            $user->email = ArrayHelper::getValue($attributes, 'email');
            $user->oauth_client = $client->getName();
            $user->oauth_client_user_id = ArrayHelper::getValue($attributes, 'id');
            $password = Yii::$app->security->generateRandomString(8);
            $user->setPassword($password);
            if ($user->save()) {
                $profileData = [];
                if ($client->getName() === 'facebook') {
                    $profileData['firstname'] = ArrayHelper::getValue($attributes, 'first_name');
                    $profileData['lastname'] = ArrayHelper::getValue($attributes, 'last_name');
                }
                $user->afterSignup($profileData);
                $sentSuccess = Yii::$app->commandBus->handle(new SendEmailCommand([
                    'view'    => 'oauth_welcome',
                    'params'  => ['user' => $user, 'password' => $password],
                    'subject' => Yii::t('frontend', '{app-name} | Your login information', ['app-name' => Yii::$app->name]),
                    'to'      => $user->email
                ]));
                if ($sentSuccess) {
                    Yii::$app->session->setFlash(
                        'alert',
                        [
                            'options' => ['class' => 'alert-success'],
                            'body'    => Yii::t('frontend', 'Welcome to {app-name}. Email with your login information was sent to your email.', [
                                'app-name' => Yii::$app->name
                            ])
                        ]
                    );
                }

            } else {
                // We already have a user with this email. Do what you want in such case
                if ($user->email && User::find()->where(['email' => $user->email])->count()) {
                    Yii::$app->session->setFlash(
                        'alert',
                        [
                            'options' => ['class' => 'alert-danger'],
                            'body'    => Yii::t('frontend', 'We already have a user with email {email}', [
                                'email' => $user->email
                            ])
                        ]
                    );
                } else {
                    Yii::$app->session->setFlash(
                        'alert',
                        [
                            'options' => ['class' => 'alert-danger'],
                            'body'    => Yii::t('frontend', 'Error while oauth process.')
                        ]
                    );
                }

            };
        }
        if (Yii::$app->user->login($user, 3600 * 24 * 30)) {
            return true;
        } else {
            throw new Exception('OAuth error');
        }
    }
}
