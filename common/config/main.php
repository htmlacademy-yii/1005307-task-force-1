<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
     //       'rules' => [
     //           '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
