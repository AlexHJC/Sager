<?php

namespace frontend\modules\user\models;

use cheatsheet\Time;
use common\commands\SendEmailCommand;
use common\models\User;
use common\models\UserProfile;
use common\models\UserToken;
use frontend\models\Companies;
use frontend\models\Plan;
use frontend\models\Subscription;
use frontend\modules\user\Module;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\Url;

/**
 * Signup form
 */
class SignupForm extends Model
{
    /**
     * @var
     */
    public $username;
    /**
     * @var
     */
    public $email;
    /**
     * @var
     */
    public $password;

    /**
     * @var
     */
    public $password_confirm;

    /**
     * @var
     */
    public $country_id;

    /**
     * @var
     */
    public $state_id;

    /**
     * @var
     */
    public $city_id;

    /**
     * @var
     */
    public $postal_code;

    /**
     * @var
     */
    public $address;

    /**
     * @var
     */
    public $company;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email', 'unique',
                'targetClass' => '\common\models\User',
                'message'     => Yii::t('frontend', 'This email address has already been taken.')
            ],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_confirm', 'required'],
            ['password_confirm', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"Passwords don't match" ],
            [['state_id', 'country_id', 'city_id'], 'integer'],
            [['address', 'company'], 'string'],
            [['postal_code', 'address', 'state_id', 'country_id', 'city_id', 'company'], 'required'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('frontend', 'Username'),
            'email'    => Yii::t('frontend', 'E-mail'),
            'password' => Yii::t('frontend', 'Password'),
            'password_confirm' => Yii::t('frontend', 'Confirm Password'),
            'country_id' => 'Country',
            'state_id' => 'State/Province',
            'city_id' => 'City/Town',
            'postal_code' => 'Postal code',
            'address' => 'Address',
            'company' => 'Company Name',
        ];
    }


    public function registerUser()
    {
        if($this->validate()){
            $shouldBeActivated = $this->shouldBeActivated();

            $user = new User();
            $user->username = $this->company;
            $user->email = $this->email;
            $user->status = $shouldBeActivated ? User::STATUS_NOT_ACTIVE : User::STATUS_ACTIVE;
            $user->setPassword($this->password);
            if($user->save()){
                $user->afterSignup();
                $nUserId = $user->id;

                if($this->_setUserSubscription($nUserId)){
                    $aCompany = array(
                        'title' => $this->company,
                        'full_address' => $this->_getFullAddress($this->country_id, $this->state_id, $this->city_id, $this->postal_code),
                        'address' => $this->address,
                        'email' => $this->email,
                        'country' => $this->country_id,
                    );
                    if($this->_createCompany($nUserId, $aCompany)){
                        // send email to user
                        if($shouldBeActivated){
                            $token = UserToken::create(
                                $user->id,
                                UserToken::TYPE_ACTIVATION,
                                Time::SECONDS_IN_A_DAY
                            );

                            Yii::$app->commandBus->handle(new SendEmailCommand([
                                'subject' => Yii::t('frontend', 'Activation email'),
                                'view' => 'activation',
                                'to' => $this->email,
                                'params' => [
                                    'url' => Url::to(['/user/sign-in/activation', 'token' => $token->token], true)
                                ]
                            ]));
                        }

                        return $user;
                    } else {
                        throw new Exception("Campaign couldn't be created.");
                    }
                } else{
                    //$this->_deleteProfile($nUserId);
                    throw new Exception("Registration failed, the subscription and campaign couldn't be created.");
                }

            } else {
                throw new Exception("User couldn't be created. Please try again.");
            }
        }

        return null;
    }

    /**
     * create and link user profile
     * @param array $profileData
     */
    public function _createProfile(array $profileData = [])
    {
        $oModel = new User();
        $oProfile = new UserProfile();
        $oProfile->locale = Yii::$app->language;
        $oProfile->load($profileData, '');
        $oModel->link('userProfile', $oProfile);
    }

    /**
     * set up user subscription
     * @throws \yii\base\Exception
     */
    public function _setUserSubscription($nUserId)
    {
        $plan = Plan::find()->where(array('is_default' => 1))->one();
        if ($plan) {
            $subscription = new Subscription();
            $subscription->user_id = $nUserId;
            $subscription->plan_id = $plan->id;
            $subscription->plan_cycle = 'month';
            $subscription->purchased_at = time();
            $subscription->start_at = time();
            $subscription->end_at = strtotime('+1 month');

            return $subscription->save();
        }

        return false;
    }


    public function _createCompany($nUserId, $aData)
    {
        $oCompany = new Companies();
        $oCompany->account_id = $nUserId;
        $oCompany->title_en = $aData['title'];
        $oCompany->title_fr = $aData['title'];
        $oCompany->adress = $aData['full_address'] . ', ' . $aData['address'];
        $oCompany->email = $aData['email'];
        $oCompany->sender_name = $aData['title'];
        $oCompany->sender_email = $aData['email'];
        $oCompany->country_id = $aData['country'];
        $oCompany->date_added = date('Y-m-d H:i:s');
        $oCompany->last_modify = date('Y-m-d H:i:s');

        return $oCompany->save();
    }


    /**
     * Signs user up.
     *
     * @return \common\models\User|null the saved model or null if saving fails
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        if ($this->validate()) {
            $shouldBeActivated = $this->shouldBeActivated();
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = $shouldBeActivated ? User::STATUS_NOT_ACTIVE : User::STATUS_ACTIVE;
            $user->setPassword($this->password);
            if (!$user->save()) {
                throw new Exception("Users couldn't be  saved");
            };

            $user->assignCompany();
            $user->afterSignup();
            if ($shouldBeActivated) {
                $token = UserToken::create(
                    $user->id,
                    UserToken::TYPE_ACTIVATION,
                    Time::SECONDS_IN_A_DAY
                );
                Yii::$app->commandBus->handle(new SendEmailCommand([
                    'subject' => Yii::t('frontend', 'Activation email'),
                    'view' => 'activation',
                    'to' => $this->email,
                    'params' => [
                        'url' => Url::to(['/user/sign-in/activation', 'token' => $token->token], true)
                    ]
                ]));

            }
            return $user;
        }

        return null;
    }

    /**
     * @return bool
     */
    public function shouldBeActivated()
    {
        /** @var Module $userModule */
        $userModule = Yii::$app->getModule('user');
        if (!$userModule) {
            return false;
        } elseif ($userModule->shouldBeActivated) {
            return true;
        } else {
            return false;
        }
    }

    public function _getFullAddress($country, $state, $city, $postal_code)
    {
        $sAddress = "";
        if(is_numeric($country) && is_numeric($state) && is_numeric($city)){

            $res = (new \yii\db\Query())
                ->select(['cr.code', 'cr.title_en as country', 'st.title_en as state', 'ct.title_en as city'])
                ->from('lic_countries as cr')
                ->join('LEFT JOIN', 'lic_states as st', 'st.country_id = cr.id')
                ->join('LEFT JOIN', 'lic_cities as ct', 'ct.state_id = st.id')
                ->where(['cr.id' => $country, 'st.id' => $state, 'ct.id' => $city])
                ->one();

            $sAddress = $res['country'] . ', ' . $res['state'] . ' ' . $res['city'] . ', ' . $postal_code;
        }

        return $sAddress;
    }
}
