<?php
// change the following paths if necessary
error_reporting(E_ERROR);
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/console.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
//define('YII_ENABLE_ERROR_HANDLER', false);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);


date_default_timezone_set('Asia/Shanghai');

require_once($yii);
Yii::createConsoleApplication($config)->run();
