<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'My Console Application',

    // preloading 'log' component
    'preload'=>array('log'),

    // application components
    'components'=>array(
        // Connect to the postgres database
        'db'=>array(
        'tablePrefix'=>'',
        'connectionString' => 'pgsql:host=localhost;port=5432;dbname=Aylas3DSPlace',
        'username'=>'postgres',
        'password'=>'somepassw',
        'charset'=>'UTF8',
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
            ),
        ),
    ),
);