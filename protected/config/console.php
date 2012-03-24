<?php

define('PROTECTED_PATH', realpath(dirname(__FILE__) . '/../') . DIRECTORY_SEPARATOR);
define('MODULES_PATH', PROTECTED_PATH . 'modules' . DIRECTORY_SEPARATOR);
define('LIBRARY_PATH', PROTECTED_PATH . 'libs' . DIRECTORY_SEPARATOR);
defined('YII_DEBUG')       || define('YII_DEBUG',false);
defined('YII_TRACE_LEVEL') || define('YII_TRACE_LEVEL',3);

$config = 'development';
//$config = 'production';

$config = include(dirname(__FILE__) . "/{$config}.php");
unset($config['preload']);

return $config;

//return ;