<?php

$config = [
    'id'           => 'basic',
    'language'     => 'ru-RU',
    'defaultRoute' => 'site/default/index',
    'modules'      => [
        'site'   => [
            'class' => 'app\modules\site\Module',
        ],
        'user'   => [
            'class' => 'app\modules\user\Module',
        ],
        'cpanel' => [
            'class' => 'app\modules\cpanel\Module',
        ],
    ],
    'components'   => [
        'user'         => [
            'identityClass'   => 'app\modules\user\models\Users',
            'enableAutoLogin' => true,
            'loginUrl'        => ['user/default/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/default/error',
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['bootstrap'][]      = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][]    = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
