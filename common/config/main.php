<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'formatter' => [
            'locale' => 'ru-RU',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'frontend\models\users\UserIdentity',
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'loginUrl' => ['landing/index']
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',
        //    'cachePath' => '@common/runtime/cache'
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
    ],
    'defaultRoute' => ['landing/index'],
    'params' => [
        'apiKey' => 'e666f398-c983-4bde-8f14-e3fec900592a'
    ]
];
