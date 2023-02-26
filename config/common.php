<?php

use yii\helpers\ArrayHelper;
use yii\symfonymailer\Mailer;

$params = ArrayHelper::merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php',
);
return [
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'language'   => 'ru-RU',
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'db'         => [
            'class'   => 'yii\db\Connection',
            'charset' => 'utf8',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
            ],
        ],
        'mailer'     => [
            'class'            => Mailer::class,
            'viewPath'         => '@app/mail',
            'useFileTransport' => true,
        ],
        'cache'      => [
            'class' => 'yii\caching\FileCache',
        ],
        'log'        => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params'     => $params,
];