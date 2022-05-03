<?php
$config = [
    'homeUrl'             => Yii::getAlias('@frontendUrl'),
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute'        => 'site/index',
    'bootstrap'           => ['maintenance'],
    'language'            => 'en_EN',
    'controllerMap'       => [
        'file-manager-elfinder' => [
            'class'            => 'mihaildev\elfinder\Controller',
            'access'           => ['manager', 'administrator', 'user'],
            'disabledCommands' => ['netmount'],
            'roots'            => [
                [
                    'baseUrl'  => '@web',
                    'basePath' => '@webroot',
                    'path'     => 'elfinder/upload',
                    //'access'   => ['read' => 'manager', 'write' => 'manager']
                ]
            ]
        ]
    ],
    'modules'             => [
        'user'     => [
            'class'             => 'frontend\modules\user\Module',
            'shouldBeActivated' => false,
        ],
        'api'      => [
            'class'   => 'frontend\modules\api\Module',
            'modules' => [
                'v1' => 'frontend\modules\api\v1\Module'
            ]
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ]
    ],
    'components'          => [
        'request'              => [
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY'),
            'baseUrl'             => '',
            'class'               => 'frontend\components\LangRequest',
        ],
        'authClientCollection' => [
            'class'   => 'yii\authclient\Collection',
            'clients' => [
                'github'   => [
                    'class'        => 'yii\authclient\clients\GitHub',
                    'clientId'     => env('GITHUB_CLIENT_ID'),
                    'clientSecret' => env('GITHUB_CLIENT_SECRET')
                ],
                'facebook' => [
                    'class'          => 'yii\authclient\clients\Facebook',
                    'clientId'       => env('FACEBOOK_CLIENT_ID'),
                    'clientSecret'   => env('FACEBOOK_CLIENT_SECRET'),
                    'scope'          => 'email,public_profile',
                    'attributeNames' => [
                        'name',
                        'email',
                        'first_name',
                        'last_name',
                    ]
                ]
            ]
        ],
        'errorHandler'         => [
            'errorAction' => 'site/error'
        ],
        'maintenance'          => [
            'class'   => 'common\components\maintenance\Maintenance',
            'enabled' => function ($app) {
                return $app->keyStorage->get('frontend.maintenance') === 'enabled';
            }
        ],
        'user'                 => [
            'class'           => 'yii\web\User',
            'identityClass'   => 'common\models\User',
            'loginUrl'        => ['/user/sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin'   => 'common\behaviors\LoginTimestampBehavior'
        ],
    ],
    'as beforeRequest'    => [
        'class'        => 'yii\filters\AccessControl',
        'rules'        => [
            [
                'allow'   => true,
                'actions' => ['get-states', 'get-cities', 'signup', 'sign-in', 'login', 'request-password-reset', 'reset-password', 'oauth', 'activation'],
                'roles'   => ['?']
            ],
            [
                'allow'   => true,
                'actions' => ['cron'],
                'roles'   => ['?'],
            ],
            [
                'allow'   => true,
                'actions' => ['cron'],
                'roles'   => ['@'],
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
        'denyCallback' => function () {
            return Yii::$app->response->redirect(['user/sign-in/login']);
        },
    ],
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class'      => 'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class'           => 'yii\gii\generators\crud\Generator',
                'messageCategory' => 'frontend'
            ]
        ]
    ];
}

return $config;
