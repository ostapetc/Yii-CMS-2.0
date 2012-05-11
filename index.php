<?
ini_set("display_errors", 1);
error_reporting(E_ALL);
ini_set('xdebug.max_nesting_level', 1000);

define('DS', DIRECTORY_SEPARATOR);

$_SERVER['DOCUMENT_ROOT'] = str_replace(array('\\', '/'), DS, $_SERVER['DOCUMENT_ROOT']);

if (substr($_SERVER['DOCUMENT_ROOT'], -1) != DS)
{
    $_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'] . DS;
}

require_once $_SERVER['DOCUMENT_ROOT'] . 'protected' . DS . 'config' . DS . 'constants.php';

$yii = LIBRARY_PATH . 'yii' . DS . 'yii.php';


date_default_timezone_set('Europe/Moscow');

require_once($yii);
require_once(LIBRARY_PATH.'functions.php');

//$session = new CHttpSession;
//$session->open();

//define('ENV', YII_DEBUG ? 'development' : 'production');
//$config = 'install';

$config = PROTECTED_PATH . 'config' . DS . (isset($config) ? $config : 'main').'.php';

Yii::createWebApplication($config)->run();
