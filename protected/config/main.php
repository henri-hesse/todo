<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Todos',

	// Default controller
	'defaultController'=>'todo',

	// preloading 'log' component
	'preload'=>array('log', 'less'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	// application components
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=todo',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			'errorAction'=>'todo/error',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(),
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		// Compile LESS files on debug mode
		'less'=>array(
			'class'=>'ext.less.components.LessCompiler',
			'forceCompile'=>YII_DEBUG, // indicates whether to force compiling
			'paths'=>array(
				'css/main.less'=>'css/main.css',
				'css/todo.less'=>'css/todo.css',
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);