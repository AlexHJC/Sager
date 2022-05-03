<?php

namespace frontend\models;

/**
 * This is the model class for table "lic_user".
 *
 * @property integer        $id
 * @property string         $username
 * @property string         $auth_key
 * @property string         $access_token
 * @property string         $password_hash
 * @property string         $oauth_client
 * @property string         $oauth_client_user_id
 * @property string         $email
 * @property integer        $status
 * @property integer        $created_at
 * @property integer        $updated_at
 * @property integer        $logged_at
 *
 * @property Subscription[] $subscriptions
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auth_key', 'access_token', 'password_hash', 'email'], 'required'],
            [['status', 'created_at', 'updated_at', 'logged_at'], 'integer'],
            [['username', 'auth_key'], 'string', 'max' => 32],
            [['access_token'], 'string', 'max' => 40],
            [['password_hash', 'oauth_client', 'oauth_client_user_id', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'id' => 'ID',
            'username'             => 'Username',
            'auth_key'             => 'Auth Key',
            'access_token'         => 'Access Token',
            'password_hash'        => 'Password Hash',
            'oauth_client'         => 'Oauth Client',
            'oauth_client_user_id' => 'Oauth Client Users ID',
            'email'                => 'Email',
            'status'               => 'Status',
            'created_at'           => 'Created At',
            'updated_at'           => 'Updated At',
            'logged_at'            => 'Logged At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptions()
    {
        return $this->hasMany(Subscription::className(), ['user_id' => 'id']);
    }

    public function getNbUsedCertificates()
    {
        $nDocs = Certificates::find()
            ->where(['>', 'expire', new Expression('NOW()')])
            ->andWhere(['=', 'modify_by', $this->id])
            ->count('id');

        return $nDocs;
    }
}
