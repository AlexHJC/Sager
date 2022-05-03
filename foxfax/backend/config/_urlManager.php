<?php
return [
    // 'class'=>'frontend\components\LangUrlManager',
    'class'           => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName'  => false,
    'rules'           => [
        // url rules
        // '' => 'admin',
        '<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
        '<controller:\w+>/<action:\w+>'          => '<controller>/<action>',

        '<module:\w+>/<controller:\w+>/<action:\w+>'                   => '<module>/<controller>/<action>',
        '<module:\w+><controller:\w+>/<action:update|delete>/<id:\d+>' => '<module>/<controller>/<action>',
    ]
];
