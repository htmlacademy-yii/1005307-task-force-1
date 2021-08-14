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
                'task/create/' => 'tasks/create/',
                'sign/' => 'sign/index',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['messages' => 'api/messages'],
                    'patterns' => [
                        'GET'  => 'view-task-messages',
                        'POST' => 'add-message',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['tasks' => 'api/tasks'],
                    'patterns' => [
                        'GET'  => 'view-executant-tasks'
                    ]
                ]
            ],
        ],
    ],
    'defaultRoute' => ['landing/index'],
];
