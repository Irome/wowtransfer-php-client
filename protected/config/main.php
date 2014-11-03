<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('booster', dirname(__FILE__) . '/../extensions/yiibooster');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'defaultController'=>'site',
	'name'=>'Перенос персонажей WoW',

	'behaviors'=>array(
		'runEnd'=>array(
			'class'=>'application.behaviors.WebApplicationEndBehavior',
		),
	),

	// preloading 'log' component
	'preload'=>array('log','booster'),

	'sourceLanguage'=>'en',
	'language'=>'ru', // to app.php

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'booster.helpers.TbHtml',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array('booster.gii'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			'class'=>'WebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>false,
		),
		// uncomment the following to enable URLs in path-format

		'booster' => array(
			'class'=>'ext.yiibooster.components.Booster',
			'responsiveCss'=>true,
			//'fontAwesomeCss'=>true,
		),

		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
			'showScriptName'=>true,
		),

		'authManager'=>array(
			'class'=>'PhpAuthManager',
			'defaultRoles'=>array('guest'),
		),

		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database

		// to app.php
		'db'=>array(
			'connectionString'=>'mysql:host=localhost;dbname=characters',
			'emulatePrepare'=>true,
			'username'=>'wowtransfer',
			'password'=>'wowtransfer',
			'charset'=>'utf8',
			'enableParamLogging'=>true,
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages

				/*array(
					'class'=>'CWebLogRoute',
				),//*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require_once(dirname(__FILE__).'/app.php'),
);