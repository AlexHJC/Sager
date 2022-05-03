<?php
return [
    // 'class'=>'yii\web\UrlManager',
    'class'           => 'frontend\components\LangUrlManager',
    'enablePrettyUrl' => true,
    'showScriptName'  => false,
    'rules'           => [
        ''                              => 'site/index',
        // '<controller:[\w-]+>/<action>/<slug>/' => '<controller>/<action>',
        // '<action>'=>'site/<action>',

        // // Pages
        ['pattern' => 'page/<slug>', 'route' => 'page/view'],
        // // // Articles
        ['pattern' => 'article/index', 'route' => 'article/index'],
        ['pattern' => 'article/attachment-download', 'route' => 'article/attachment-download'],
        ['pattern' => 'article/<slug>', 'route' => 'article/view'],
        ['pattern' => 'article/<slug>', 'route' => 'article/view'],

        // // // Api
        // ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/article', 'only' => ['index', 'view', 'options']],
        // ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/user', 'only' => ['index', 'view', 'options']]
        '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        // '<controller:\w+>/<action:\w+>/*'=>'<controller>/<action>',
    ]
];
