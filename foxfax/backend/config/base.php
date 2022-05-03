<?php
return [
    'id'         => 'backend',
    'basePath'   => dirname(__DIR__),
    // 'language' => 'en',
    'components' => [
        // 'baseUrl'=>$baseUrl,
        'urlManager'    => require(__DIR__ . '/_urlManager.php'),
        'frontendCache' => require(Yii::getAlias('@frontend/config/_cache.php'))
    ],
];
