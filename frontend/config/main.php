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
                'tasks/' => 'tasks/index',
                'users/' => 'users/index',
                'tasks/<page:\d+>' => 'tasks/index',
                'users/<page:\d+>' => 'users/index',
                'task/view/<id>' => 'tasks/view/',
                'user/view/<id>' => 'users/view/',
                'task/create/' => 'tasks/create/',
                'sign/' => 'sign/index',
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/messages',
                    'pluralize' => false]
            ],
        ],
        'session' => [
            'name' => 'advanced-frontend',
            'class' => 'yii\redis\Session',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'phpdemo.ru',
                'username' => 'keks@phpdemo.ru',
                'password' => 'htmlacademy',
                'port' => 465,
                'encryption' => 'ssl',
                'streamOptions' => ['ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],]
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '7990872',
                    'clientSecret' => 'SOB0UHXK50eEJLIX91M5',
                    'returnUrl' => 'https://yii-taskforce/sign/auth?authclient=vkontakte',
                    'apiVersion' => '5.130',
                    'scope' => 'email',
                ],
            ],
        ],
        'yandexMapsApi' => [
            'class' => 'mirocow\yandexmaps\Api',
        ],
    ],
    'defaultRoute' => 'landing/index',
    'params' => [
        'params' => $params,
    ],
    'modules' => [
        'api' => [
            'class' => 'frontend\modules\api\Module'
        ]
    ],
];
