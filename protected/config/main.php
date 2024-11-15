<?php
require_once('protected/functions/FApplication.class.php');
require_once('protected/functions/FDate.class.php');

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'RAINBOW ERP - Framework v2.0.0',
   
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
	   'application.models.*',
      'application.models.rainbow.*',
      'application.models.widgets.Toolbox.DataExporter.*',
      'application.models.widgets.Dropzone.*',
      'application.models.module_visitors_management.*',
      'application.models.module_access_control_management.*',
      'application.models.module_working_parts_management.*',
      'application.models.module_digital_diary_management.*',
      'application.models.module_plant_maintenance_management.*',
      'application.models.module_warehouse_management.*',
      'application.models.module_plant_monitoring_management.*',
      'application.models.module_purchases_management.*',
	   'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'password',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
         'loginUrl'=>array('site/index'),
			'allowAutoLogin'=>true,
         'class'=>'WebUser',
		),

		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString'=>'mysql:host=localhost;dbname=db_rainbow_common',
			'emulatePrepare'=>true,
			'username'=>'root',
			'password'=>'',
			'charset'=>'utf8',
		),
      'db_rainbow_visitorsmanagement'=>array(
         'connectionString'=>'mysql:host=localhost;dbname=db_rainbow_visitorsmanagement',
         'emulatePrepare'=>true,
         'username'=>'root',
         'password'=>'',
         'charset'=>'utf8',
         'class'  =>'CDbConnection',
      ),
      'db_rainbow_accesscontrolmanagement'=>array(
         'connectionString'=>'mysql:host=localhost;dbname=db_rainbow_accesscontrolmanagement',
         'emulatePrepare'=>true,
         'username'=>'root',
         'password'=>'',
         'charset'=>'utf8',
         'class'  =>'CDbConnection',
      ),
      'db_rainbow_workingpartsmanagement'=>array(
         'connectionString'=>'mysql:host=localhost;dbname=db_rainbow_workingpartsmanagement',
         'emulatePrepare'=>true,
         'username'=>'root',
         'password'=>'',
         'charset'=>'utf8',
         'class'  =>'CDbConnection',
      ),
      'db_rainbow_digitaldiarymanagement'=>array(
         'connectionString'=>'mysql:host=localhost;dbname=db_rainbow_digitaldiarymanagement',
         'emulatePrepare'=>true,
         'username'=>'root',
         'password'=>'',
         'charset'=>'utf8',
         'class'  =>'CDbConnection',
      ),
      'db_rainbow_plantmaintenancemanagement'=>array(
         'connectionString'=>'mysql:host=localhost;dbname=db_rainbow_plantmaintenancemanagement',
         'emulatePrepare'=>true,
         'username'=>'root',
         'password'=>'',
         'charset'=>'utf8',
         'class'  =>'CDbConnection',
      ),
      'db_rainbow_warehousemanagement'=>array(
         'connectionString'=>'mysql:host=localhost;dbname=db_rainbow_warehousemanagement',
         'emulatePrepare'=>true,
         'username'=>'root',
         'password'=>'',
         'charset'=>'utf8',
         'class'  =>'CDbConnection',
      ),
      'db_rainbow_plantmonitoringmanagement'=>array(
         'connectionString'=>'mysql:host=localhost;dbname=db_rainbow_plantmonitoringmanagement',
         'emulatePrepare'=>true,
         'username'=>'root',
         'password'=>'',
         'charset'=>'utf8',
         'class'  =>'CDbConnection',
      ),
      'db_rainbow_purchasesmanagement'=>array(
         'connectionString'=>'mysql:host=localhost;dbname=db_rainbow_purchasesmanagement',
         'emulatePrepare'=>true,
         'username'=>'root',
         'password'=>'',
         'charset'=>'utf8',
         'class'  =>'CDbConnection',
      ),
      
      'db_rainbow_remote'=>array(
         'connectionString'=>'mysql:host=192.168.200.3;dbname=db_rainbow_common',
         'emulatePrepare'=>true,
         'username'=>'root',
         'password'=>'',
         'charset'=>'utf8',
         'class'  =>'CDbConnection',
      ),
      'db_rainbow_visitorsmanagement_remote'=>array(
         'connectionString'=>'mysql:host=192.168.200.3;dbname=db_rainbow_visitorsmanagement',
         'emulatePrepare'=>true,
         'username'=>'root',
         'password'=>'',
         'charset'=>'utf8',
         'class'  =>'CDbConnection',
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
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
      'widgetFactory'=>array(
          'widgets'=>array(
              'CGridView'=>array(
                  'cssFile'=>'components/gridview/gridview.css',
              ),
          ),
      ),  
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
        'applicationSystem'=>FApplication::SYSTEM_UNIX,
        'applicationName'=>'RAINBOW ERP - Framework',
        'applicationVersion'=>'v2.0.0',
        
        'companyName'=>'Rainbow',
        'companyPhone'=>'(+ext) 111 111 111',
		  'companyMail'=>'user@rainbow.es',
        
        'timeZone'=>FDate::TIMEZONE_EUROPE_MADRID,
        'loginUrl'=>'site/index',
        'frontEndUrl'=>'frontend/site/index',
        'backEndUrl'=>'backend/site/index',
        'errorUrl'=>'site/error',
        
        'paramShowLoading'=>false,  
         
        'paramEventsEnable'=>true,
        'paramEventsOnScreenSeconds'=>5,
        'paramEventsRequestDelayMinutes'=>1, 
        'paramEventsRequestMaxLastDays'=>2,
	),     
);