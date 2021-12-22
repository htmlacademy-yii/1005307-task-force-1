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
        'cache' => [
            'class' => 'yii\redis\Cache',
        //    'cachePath' => '@common/runtime/cache'
        ],
    ],
    'defaultRoute' => ['landing/index'],
    'params' => [
        'apiKey' => 'e666f398-c983-4bde-8f14-e3fec900592a'
    ]
];
