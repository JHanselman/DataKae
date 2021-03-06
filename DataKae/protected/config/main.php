<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'DataKae!',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.controllers.3DS.*'
    ),
    
    'modules'=>array(
        // uncomment the following to enable the Gii tool
        
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'somepassw',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
        ),
        
        'forum'=>array(
            'class'=>'application.modules.bbii.BbiiModule',
            'adminId'=>10,
            'forumTitle' => 'DataKae Forum',
            'userClass'=>'User',
            'userIdColumn'=>'"userId"',
            'userNameColumn'=>'userName',
            'userMailColumn'=>'emailAddress',
            'bbiiTheme'=>'datakae',
        ),  
    ),

    // application components
    'components'=>array(
        'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
        ),
        
        
        // uncomment the following to enable URLs in path-format
        
        'urlManager'=>array(
            'urlFormat'=>'path',
            'rules'=>array(
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                '3DS/<controller:\w+>/<action:\w+>'=>'3DS/<controller>/<action>',
                'WiiU/<controller:\w+>/<action:\w+>'=>'WiiU/<controller>/<action>'
            ),
        ),
        
        
        // Connect to the postgres database
        'db'=>array(
        'tablePrefix'=>'',
        'connectionString' => 'pgsql:host=localhost;port=5432;dbname=DataKaeDatabase',
        'username'=>'postgres',
        'password'=>'somepassw',
        'charset'=>'UTF8',
        'enableProfiling'=>true,
        'enableParamLogging' => true,
        ),
        
        //Configure Authmanager to use database
        'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
            'defaultRoles'=>array('authenticated', 'guest'),
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
                    'levels'=>'trace, info, error, warning, vardump',
                ),
                array(
                    'class'=>'CProfileLogRoute',
                    'levels'=>'profile',
                    'enabled'=>true,
                ),
                // uncomment the following to show log messages on web pages
                array(
                    'class' => 'CWebLogRoute',
                    'enabled' => YII_DEBUG,
                    'levels' => 'error, warning, trace, notice',
                    'categories' => 'application, vardump',
                    'showInFireBug' => false,
                ),
            ),
        ),
        //'clientScript'=>array(
        //'coreScriptPosition' => CClientScript::POS_END),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
        // this is used in contact page
        'adminEmail'=>'webmaster@example.com',
        'PBKDF2_HASH_ALGORITHM' => "sha256",
        'PBKDF2_ITERATIONS' => 1000,
        'PBKDF2_SALT_BYTE_SIZE' => 24,
        'PBKDF2_HASH_BYTE_SIZE' => 24,
        'HASH_SECTIONS' => 4,
        'HASH_ALGORITHM_INDEX' => 0,
        'HASH_ITERATION_INDEX' => 1,
        'HASH_SALT_INDEX' => 2,
        'HASH_PBKDF2_INDEX' => 3
    ),
);