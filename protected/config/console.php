<?
define('PROTECTED_PATH', realpath(dirname(__FILE__) . '/../') . DIRECTORY_SEPARATOR);
define('MODULES_PATH', PROTECTED_PATH . 'modules' . DIRECTORY_SEPARATOR);
define('LIBRARY_PATH', PROTECTED_PATH . 'libs' . DIRECTORY_SEPARATOR);


return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
//	'name'=>'My Console Application',
//	// application components
//	'components'=>array(
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
//	),
);