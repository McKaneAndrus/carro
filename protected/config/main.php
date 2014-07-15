<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Achacarro',
	
	//default language
	'sourceLanguage' => 'en_us', 	// source 
	'language' => 'pt_br',			// target language brazil is 'pt_br'
	
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.YiiMailer.YiiMailer',	// simple mailer component
		'bootstrap.helpers.TbHtml',	// Yiistrap bootstrap related
		'bootstrap.helpers.TbArray',
		'bootstrap.behaviors.*',	
		'bootstrap.components.*',
	),

	'aliases' => array(
        // yiistrap configuration
        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change if necessary
        // yiiwheels configuration
        'yiiwheels' => realpath(__DIR__ . '/../extensions/yiiwheels'), // change if necessary
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
			'allowAutoLogin'=>false,
		),

		// yiistrap configuration
 	 	'bootstrap' => array(
 	    	'class' => 'bootstrap.components.TbApi',   
 	   	),

 	   	// yiiwheels configuration
 	   	'yiiwheels' => array(
 	   		'class' => 'yiiwheels.YiiWheels',   
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

				// a custom rule to handle '/Make/Model' see CarUrlRule.php in /components
				
				array(
					'class' => 'application.components.CarUrlRule',
				),

				'<action:\w+>'=>'site/<action>',	// simple map rule that will send .../about to the about page...
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
		'AckEmailAdr' => 'suporte@achacarro.com', 	// Thank You Email FROM address
		'AckEmailName' => 'Suporte ao Cliente',		// Thank You Email Human Name
		'EmailDupeDays' => 7,						// Number of days to check back for dupes, 0 disables
		'version'=>'2.03',
	),
);
