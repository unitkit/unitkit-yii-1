<?php
// environment type
define('B_DEV_ENV', 'dev');
define('B_PROD_ENV', 'prod');

// current environment
define('B_APP_ENV', B_DEV_ENV);

// if production 0 else E_ALL
error_reporting(B_APP_ENV === B_DEV_ENV ? E_ALL : 0);

// debug
define('YII_DEBUG', B_APP_ENV === B_DEV_ENV);

// specify how many levels of call stack should be shown in each log message
define('YII_TRACE_LEVEL', 1);

date_default_timezone_set('Europe/Paris');

require __DIR__ . '/../../yiiFramework/yii.php';

$app = Yii::createWebApplication(__DIR__ . '/../../unitkit/modules/backend/config/main.php');
if (Yii::app()->id == '') {
    throw new Exception('Unique app ID is required. Please configure your application.');
}
$app->run();