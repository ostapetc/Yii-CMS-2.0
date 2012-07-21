<?php
/**
 * Yii command line script file.
 *
 * This script is meant to be run on command line to execute
 * one of the pre-defined console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @version $Id: yiic.php 2799 2011-01-01 19:31:13Z qiang.xue $
 */

// fix for fcgi
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));

defined('YII_DEBUG') or define('YII_DEBUG',true);

define('DS', DIRECTORY_SEPARATOR);
if (!isset($_SERVER['DOCUMENT_ROOT']) || !$_SERVER['DOCUMENT_ROOT'])
{
    $_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../../../') . DS;
}

require_once $_SERVER['DOCUMENT_ROOT'] . 'protected' . DS . 'config' . DS . 'constants.php';
require_once(dirname(__FILE__).'/yii.php');
require_once LIBRARIES_PATH . 'functions.php';
require_once LIBRARIES_PATH . 'debug.php';


$env = YII_DEBUG ? 'development' : 'production';
defined('ENV') || define('ENV', $env);
defined('CONFIG') || define('CONFIG', $env);

$config = $_SERVER['DOCUMENT_ROOT'].'/protected/config/console.php';

if(isset($config))
{
	$app=Yii::createConsoleApplication($config);
	$app->commandRunner->addCommands(YII_PATH.'/cli/commands');
	$env=@getenv('YII_CONSOLE_COMMANDS');
	if(!empty($env))
		$app->commandRunner->addCommands($env);
}
else
	$app=Yii::createConsoleApplication(array('basePath'=>dirname(__FILE__).'/cli'));

$app->run();