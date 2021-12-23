<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'language' => 'ru-RU',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'formatter' => [
            'class' => 'frontend\components\MyFormatter',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'frontend\models\account\UserIdentity',
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'loginUrl' => ['landing/index']
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '/' => 'landing/index',
                'sign/' => 'sign/index',
                'tasks/' => 'tasks/index',
                'users/' => 'users/index',
                'profile/' => 'profile/index',
                'my-tasks/' => 'my-tasks/index',
                'task/view/<id>' => 'tasks/view/',
                'user/view/<id>' => 'users/view/',
                'task/create/' => 'tasks/create/',
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/messages',
                    'pluralize' => false]
            ],
        ],
        'session' => [
            'name' => 'advanced-frontend',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',
        ],
        'yandexMapsApi' => [
            'class' => 'mirocow\yandexmaps\Api',
        ],
    ],
    'defaultRoute' => 'landing/index',
    'params' => [
        'params' => $params,
        'apiKey' => 'e666f398-c983-4bde-8f14-e3fec900592a',
        'email' => 'anyakulikova111@yandex.ru'
    ],
    'modules' => [
        'api' => [
            'class' => 'frontend\modules\api\Module',
        ]
    ],
];
