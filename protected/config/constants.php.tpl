<?
define('DS', DIRECTORY_SEPARATOR);
define('ENV', '{{env}}');
define('YII_DEBUG', true);
define('APP_PATH', $_SERVER['DOCUMENT_ROOT'] . 'protected' . DS);
define('RUNTIME_PATH', APP_PATH . 'runtime' . DS);
define('MODULES_PATH', APP_PATH . 'modules' . DS);
define('LIBRARIES_PATH', APP_PATH . 'libs' . DS);
define('YII_TRACE_LEVEL',3);