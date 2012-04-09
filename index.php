<?
define('DS', DIRECTORY_SEPARATOR);

$_SERVER['DOCUMENT_ROOT'] = str_replace(array('\\', '/'), DS, $_SERVER['DOCUMENT_ROOT']);

if (substr($_SERVER['DOCUMENT_ROOT'], -1) != DS)
{
    $_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'] . DS;
}

require_once $_SERVER['DOCUMENT_ROOT'] . 'protected' . DS . 'config' . DS . 'constants.php';

$yii = LIBRARY_PATH . 'yii' . DS . 'yii.php';

ini_set("display_errors", 1);
error_reporting(E_ALL);

date_default_timezone_set('Europe/Moscow');

require_once($yii);
require_once(LIBRARY_PATH.'functions.php');

$session = new CHttpSession;
$session->open();

$config = YII_DEBUG ? 'development' : 'production';
$config = PROTECTED_PATH . DS . 'config' . DS . $config . '.php';

Yii::createWebApplication($config)->run();
