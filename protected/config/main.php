<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Carro Online',

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
		// sjg - remove for production
		//
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=> false,
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=newcars', //revmaker',
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
		'adminEmail'=>'webmaster@carro.br.com',	// sjg - need to fix if used
		'Country_Code' =>'BR',					// pick something to make the app aware of cc, could be useful for database table prefix at some point too.
	),
);
