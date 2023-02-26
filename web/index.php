<?php

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

//$config = require __DIR__ . '/../config/web.php';
$config = ArrayHelper::merge(
    require __DIR__ . '/../config/common.php',
    require __DIR__ . '/../config/common-local.php',
    require __DIR__ . '/../config/web.php',
    require __DIR__ . '/../config/web-local.php',
);

try {
    (new yii\web\Application($config))->run();
} catch (InvalidConfigException $e) {
}
