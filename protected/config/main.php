<?php
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Todos',

	// Default controller
	'defaultController'=>'site',

	// preloading 'log' component
	'preload'=>array('log', 'less'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// Default database connection details.
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=todo',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		// Redirects errors.
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(),
		),
		// Logs errors to a log file.
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
		// Compile LESS files on debug mode
		'less'=>array(
			'class'=>'ext.less.components.LessCompiler',
			'forceCompile'=>YII_DEBUG, // indicates whether to force compiling
			'paths'=>array(
				'css/site.less'=>'css/site.css',
				'css/todo.less'=>'css/todo.css',
			),
		),
	),
);