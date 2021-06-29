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
            'identityClass' => 'frontend\models\users\UserIdentity',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'loginUrl' => ['landing/index']
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '//' => '/',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<filter:\d+>' => '<controller>/<action>'
            ],

            'cache' => [
                'class' => 'yii\caching\FileCache',
            ],
        ],
    ],
    'params' => $params,
    'defaultRoute' => ['landing/index'],
    'homeUrl' => ['tasks/index'],
];
