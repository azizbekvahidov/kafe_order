<?php

// uncomment the following to define a path alias
 Yii::setPathOfAlias('local','test');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'KIF Foods',
    'language'=>'ru',

    'aliases'=>array(
//		'bootstrap'=> realpath(__DIR__.'/../extensions/yiibooster'),
	),

	// preloading 'log' component
	'preload'=>array('log'),
//    'theme'=>'heart',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
//		'gii'=>array(
//			'class'=>'system.gii.GiiModule',
//			'password'=>'213',
//			// If removed, Gii defaults to localhost only. Edit carefully to taste.
//			'ipFilters'=>array('127.0.0.1','::1'),
//            'generatorPaths'=>array('ext.heart.gii'),
//		),
//        'order',
//		'cooking',
	),

	// application components
	'components'=>array(
        'config' => array(
            'class' => 'application.extensions.EConfig',
        ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
            'class' => 'WebUser',
		),

		// uncomment the following to enable URLs in path-format

        /*'authManager' => array(
            // Будем использовать свой менеджер авторизации
            'class' => 'PhpAuthManager',
            // Роль по умолчанию. Все, кто не админы, модераторы и юзеры — гости.
            //'defaultRoles' => array('0'),
        ),*/

		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

        /*'log' => array(
            'class'  => 'CLogRouter',
            'routes' => array(
                array(
                    'class'  => 'CFileLogRoute',
                    'levels' => '', // ВОТ ТУТ ПУСТАЯ СТРОКА!!!
                ),
                /*array(
                    'class'        => 'ext.db_profiler.DbProfileLogRoute',
                    'countLimit'   => 1, // How many times the same query should be executed to be considered inefficient
                    'slowQueryMin' => 0.01, // Minimum time for the query to be slow
                ),

            ),
        ),
        'bootstrap'=>array(
			'class'=>'bootstrap.components.Booster',
			'fontAwesomeCss'=>true,
			'minify'=>true,

		),*/
		'themeManager'=>array(
			'basePath'=>'protected/extensions',
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);
