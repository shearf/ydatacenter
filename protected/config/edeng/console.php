<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$logFilePath = dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'runtime';
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..',
	'name'=>'易登数据',
	
	'commandPath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'edeng'.DIRECTORY_SEPARATOR.'commands',
	//'sourceLanguage'=>'zh_cn',
	'timeZone'=>'Asia/Shanghai',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		//'application.models.*',
		'application.components.*',
		'application.modules.edeng.models.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'edeng' => array(
			'class' => 'application.modules.edeng.EdengModule',
		),
	),

	// application components
	'components'=>array(
	
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=y_data_center',
			'emulatePrepare' => true,
			'tablePrefix' => 'edeng_',
			'username' => 'y_data_center',
			'password' => 'YDataCenter',
			'charset' => 'utf8',
		),
		'fetch' => array(
			'class' => 'application.modules.edeng.components.FetchEdeng'
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'logPath' => $logFilePath,
					'logFile' => 'edeng.console.log',
					'levels'=>'error, warning',
				),
			),
		),
	),
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'xiahaihu2009@gmail.com',
	),
);