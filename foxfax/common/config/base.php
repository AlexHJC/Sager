<?php
$config = [
    'name'           => 'License Admin',
    'vendorPath'     => dirname(dirname(__DIR__)) . '/vendor',
    'extensions'     => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'sourceLanguage' => 'kl',
    'language'       => 'en',
    'bootstrap'      => [
        'log',
        'languageSwitcher',
    ],
    'components'     => [

        'authManager' => [
            'class'           => 'yii\rbac\DbManager',
            'itemTable'       => '{{%rbac_auth_item}}',
            'itemChildTable'  => '{{%rbac_auth_item_child}}',
            'assignmentTable' => '{{%rbac_auth_assignment}}',
            'ruleTable'       => '{{%rbac_auth_rule}}'
        ],

        'cache' => [
            'class'     => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache'
        ],

        'commandBus' => [
            'class'       => 'trntv\bus\CommandBus',
            'middlewares' => [
                [
                    'class'                  => '\trntv\bus\middlewares\BackgroundCommandMiddleware',
                    'backgroundHandlerPath'  => '@console/yii',
                    'backgroundHandlerRoute' => 'command-bus/handle',
                ]
            ]
        ],

        'formatter' => [
            'class' => 'yii\i18n\Formatter'
        ],

        'languageSwitcher' => [
            'class' => 'common\components\languageSwitcher',
        ],

        'glide' => [
            'class'        => 'trntv\glide\components\Glide',
            'sourcePath'   => '@storage/web/source',
            'cachePath'    => '@storage/cache',
            'urlManager'   => 'urlManagerStorage',
            'maxImageSize' => env('GLIDE_MAX_IMAGE_SIZE'),
            'signKey'      => env('GLIDE_SIGN_KEY')
        ],

        'mailer' => [
            'class'         => 'yii\swiftmailer\Mailer',
            //'useFileTransport' => true,
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from'    => env('ADMIN_EMAIL')
            ]
        ],

        'mail' => [
            'class'     => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class'         => 'Swift_SmtpTransport',
                //'host' => env('SMTP_HOST2'),  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                //'username' => env('SMTP_EMAIL'),
                //'password' => env('SMTP_PASSWD'),
                //'port' => env('SMTP_PORT2'), // Port 25 is a very common port too
                //'encryption' => env('SMTP_ENCRIPTION'), // It is often used, check your provider or mail server specs
                'plugins'       => [
                    [
                        'class'         => 'Swift_Plugins_ThrottlerPlugin',
                        'constructArgs' => [20],
                    ],
                ],
                'streamOptions' => [
                    'ssl' => [
                        'verify_peer'      => false,
                        'verify_peer_name' => false,
                    ],
                ],
            ],
        ],

        'db' => [
            'class'             => 'yii\db\Connection',
            'dsn'               => env('DB_DSN'),
            'username'          => env('DB_USERNAME'),
            'password'          => env('DB_PASSWORD'),
            'tablePrefix'       => env('DB_TABLE_PREFIX'),
            'charset'           => 'utf8',
            'enableSchemaCache' => YII_ENV_PROD,
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                'db' => [
                    'class'    => 'yii\log\DbTarget',
                    'levels'   => ['error', 'warning'],
                    'except'   => ['yii\web\HttpException:*', 'yii\i18n\I18N\*'],
                    'prefix'   => function () {
                        $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;
                        return sprintf('[%s][%s]', Yii::$app->id, $url);
                    },
                    'logVars'  => [],
                    'logTable' => '{{%system_log}}'
                ]
            ],
        ],

        'i18n' => [
            'translations' => [
                'app' => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                /*
                '*'=> [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath'=>'@common/messages',
                    'fileMap'=>[
                        'common'=>'common.php',
                        'backend'=>'backend.php',
                        'frontend'=>'frontend.php',
                    ],
                    'on missingTranslation' => [
                        '\backend\modules\i18n\Module', 
                        'missingTranslation'
                    ]
                ],
                */
                '*'   => [
                    'class'                 => 'yii\i18n\DbMessageSource',
                    'sourceMessageTable'    => '{{%i18n_source_message}}',
                    'messageTable'          => '{{%i18n_message}}',
                    'enableCaching'         => YII_ENV_DEV,
                    'cachingDuration'       => 3600,
                    'on missingTranslation' => ['\backend\modules\i18n\Module', 'missingTranslation']
                ],
                /* Uncomment this code to use DbMessageSource
                */
            ],
        ],

        'fileStorage' => [
            'class'      => '\trntv\filekit\Storage',
            'baseUrl'    => '@storageUrl/source',
            'filesystem' => [
                'class' => 'common\components\filesystem\LocalFlysystemBuilder',
                'path'  => '@storage/web/source'
            ],
            'as log'     => [
                'class'     => 'common\behaviors\FileStorageLogBehavior',
                'component' => 'fileStorage'
            ]
        ],

        'keyStorage' => [
            'class' => 'common\components\keyStorage\KeyStorage'
        ],

        'urlManagerBackend'  => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => Yii::getAlias('@backendUrl')
            ],
            require(Yii::getAlias('@backend/config/_urlManager.php'))
        ),
        'urlManagerFrontend' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => Yii::getAlias('@frontendUrl')
            ],
            require(Yii::getAlias('@frontend/config/_urlManager.php'))
        ),
        'urlManagerStorage'  => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => Yii::getAlias('@storageUrl')
            ],
            require(Yii::getAlias('@storage/config/_urlManager.php'))
        )
    ],
    'params'         => [
        //'paypal_client_id'     => '',
        //'paypal_client_secret' => '',
        'paypal_mode'          => 'live', // sandbox or live
        'adminEmail'           => env('ADMIN_EMAIL'),
        'robotEmail'           => env('ROBOT_EMAIL'),
        'availableLocales'     => [
            'en' => 'English (US)',
            'fr' => 'Francais (FR)',
            // 'ro'=>'Romina (RO)',
            // 'ru'=>'Русский (РФ)',
            // 'en-US'=>'English (US)',
            // 'uk-UA'=>'Українська (Україна)',
            // 'es' => 'Español',
            // 'zh-CN' => '简体中文',
        ],
        'status'               => [
            'active'   => 'Active',
            'inactive' => 'Inactive',
        ],
        'state'                => [
            'waiting' => 'Waiting',
            'sent'    => 'Sent',
        ],
        'yes'                  => [
            'yes' => 'Yes',
            'no'  => 'No',
        ],
    ],
];

if (YII_ENV_PROD) {
    $config['components']['log']['targets']['email'] = [
        'class'   => 'yii\log\EmailTarget',
        'except'  => ['yii\web\HttpException:*'],
        'levels'  => ['error', 'warning'],
        'message' => ['from' => env('ROBOT_EMAIL'), 'to' => env('ADMIN_EMAIL')]
    ];
}

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module'
    ];

    $config['components']['cache'] = [
        'class' => 'yii\caching\DummyCache'
    ];
    $config['components']['mailer']['transport'] = [
        'class' => 'Swift_SmtpTransport',
        //'host' => env('SMTP_HOST'),
        //'port' => env('SMTP_PORT'),
    ];
}

return $config;
