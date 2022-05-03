<?php

namespace frontend\models;


use cheatsheet\Time;
use common\commands\SendEmailCommand;
use common\models\User;
use common\models\UserToken;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\Url;


class UserCreateForm extends Model
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
    public $send_email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            [
                'username', 'unique',
                'targetClass' => '\common\models\User',
                'message'     => Yii::t('frontend', 'This username has already been taken.')
            ],
            ['username', 'string', 'min' => 2, 'max' => 255],

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
            ['send_email', 'integer', 'min' => 0, 'max' => 1],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username'   => Yii::t('frontend', 'Username'),
            'email'      => Yii::t('frontend', 'E-mail'),
            'password'   => Yii::t('frontend', 'Password'),
            'send_email' => Yii::t('frontend', 'Send activation email.'),
        ];
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
            $shouldBeActivated = (!empty($this->send_email)) ? true : false;
            $user = new User();
            $user->username = $this->username;
            $user->parent_id = Yii::$app->user->identity->id;
            $user->email = $this->email;
            $user->status = 2;
            $user->setPassword($this->password);
            if (!$user->save()) {
                throw new Exception("Users couldn't be  saved");
            };

            $user->afterSignup();
            if ($shouldBeActivated) {
                $token = UserToken::create(
                    $user->id,
                    UserToken::TYPE_ACTIVATION,
                    Time::SECONDS_IN_A_DAY
                );
                Yii::$app->commandBus->handle(new SendEmailCommand([
                    'subject' => Yii::t('frontend', 'Activation email'),
                    'view'    => 'activation',
                    'to'      => $this->email,
                    'params'  => [
                        'url' => Url::to(['/user/sign-in/activation', 'token' => $token->token], true)
                    ]
                ]));

            }
            return $user;
        }

        return null;
    }

    public function edit()
    {

    }

}