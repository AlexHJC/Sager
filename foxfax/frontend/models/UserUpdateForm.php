<?php

namespace frontend\models;


use common\models\User;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\web\JsExpression;


class UserUpdateForm extends Model
{

    public $username;
    public $email;
    public $password;
    public $password_confirm;

    private $user;

    private $model;

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
                'targetClass' => User::className(),
                'filter'      => function ($query) {
                    if (!$this->getModel()->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->getModel()->id]]);
                    }
                }
            ],
            ['username', 'string', 'min' => 1, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email', 'unique',
                'targetClass' => User::className(),
                'filter'      => function ($query) {
                    if (!$this->getModel()->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->getModel()->id]]);
                    }
                }
            ],
            ['password', 'string'],
            [
                'password_confirm',
                'required',
                'when'       => function ($model) {
                    return !empty($model->password);
                },
                'whenClient' => new JsExpression("function (attribute, value) {
                    return $('#caccountform-password').val().length > 0;
                }")
            ],
            ['password_confirm', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false],

        ];
    }

    /**
     * @return \common\models\User
     */
    public function getModel()
    {
        if (!$this->model) {
            $this->model = new User();
        }
        return $this->model;
    }

    /**
     * @param $model
     *
     * @return mixed
     */
    public function setModel($model)
    {
        $this->username = $model->username;
        $this->email = $model->email;
        $this->model = $model;
        return $this->model;
    }

    public function attributeLabels()
    {
        return [
            'username'         => Yii::t('frontend', 'Username'),
            'email'            => Yii::t('frontend', 'Email'),
            'password'         => Yii::t('frontend', 'Password'),
            'password_confirm' => Yii::t('frontend', 'Confirm Password')
        ];
    }

    public function save()
    {
        if ($this->validate()) {
            $model = $this->getModel();

            $model->username = $this->username;
            $model->email = $this->email;
            if ($this->password) {
                $model->setPassword($this->password);
            }

            if (!$model->save()) {
                throw new Exception('Model not saved');
            }

            return !$model->hasErrors();
        }

        return null;
        /*
        $this->user->username = $this->username;
        $this->user->email = $this->email;
        if ($this->password) {
            $this->user->setPassword($this->password);
        }
        return $this->user->save();
        */
    }

}