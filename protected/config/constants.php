<?

if (!$_SERVER['DOCUMENT_ROOT']) //for console application
{
    $_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../../').'/';
}

defined('YII_DEBUG')       || define('YII_DEBUG', true);
defined('PROTECTED_PATH')  || define('PROTECTED_PATH', $_SERVER['DOCUMENT_ROOT'] . 'protected/');
defined('MODULES_PATH')    || define('MODULES_PATH', $_SERVER['DOCUMENT_ROOT'] . 'protected/modules/');
defined('LIBRARY_PATH')    || define('LIBRARY_PATH', PROTECTED_PATH . 'libs/');
defined('YII_TRACE_LEVEL') || define('YII_TRACE_LEVEL',3);