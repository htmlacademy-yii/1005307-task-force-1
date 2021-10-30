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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '/' => 'landing/index',
                'tasks/' => 'tasks/index',
                'users/' => 'users/index',
                'tasks/<page:\d+>' => 'tasks/index',
                'users/<page:\d+>' => 'users/index',
                'task/view/<id>' => 'tasks/view/',
                'user/view/<id>' => 'users/view/',
                'sign/' => 'sign/index',
                'task/create/' => 'tasks/create/'
            ],
        ]
    ],
    'defaultRoute' => ['landing/index'],
    'params' => [
        'apiKey' => 'e666f398-c983-4bde-8f14-e3fec900592a'
    ]
];
