<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Carro',
	
	//default language
	'sourceLanguage' => 'en_us', 	// source 
	'language' => 'pt_br',			// target language brazil is 'pt_br'
	
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		
		// 
		// uncomment the following to enable the Gii tool
		// sjg - dont forget to comment out for production!
		//
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=> false,
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		
		'session' => array(
			'timeout' => 1440,	// 1440 seconds typical session tko, affected after close of browser
			'sessionName' => 'RevmakerNCP',
			'cookieMode' => 'only',
			'savePath' => dirname(__FILE__).DIRECTORY_SEPARATOR . '../runtime/sessions', // up from config, back down to runtime. Note dir must exist and be we writable 
		),
	  
		// uncomment the following to enable URLs in path-format
	
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false, // added to not show script name
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>', 
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=newcars', 
			'emulatePrepare' => true,
			'username' => 'revmaker',
			'password' => 'revmaker',
			'charset' => 'utf8',
			'tablePrefix' => 'br_', 	// affects {{tablename}} usage in queries
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
				
				// uncomment to show sql in log
				/*
				
				array(
					'class'=>'CFileLogRoute',
					'categories'=>'system.db.*',				
					'levels'=>'trace, info',
				),
				
				
				*/
				
				// uncomment the following to show log messages on web pages
				
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@carro.br.com',
		'version'=>'1.02',
	),
);
