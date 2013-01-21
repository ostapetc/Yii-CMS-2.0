<?php

$_SERVER['DOCUMENT_ROOT']  = realpath(dirname(__FILE__) . '/../../') . DIRECTORY_SEPARATOR;

require_once $_SERVER['DOCUMENT_ROOT'] . 'protected/config/ini_set.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'protected/config/constants.php';
require_once(LIBRARY_PATH . 'yii' . DS . 'yii.php');
require_once(LIBRARY_PATH . 'functions' . DS . 'debug_functions.php');
require_once(LIBRARY_PATH . 'functions' . DS . 'php_5_3_functions.php');

$config = trim(file_get_contents($_SERVER["DOCUMENT_ROOT"] . '.env'));
$config = realpath(dirname(__FILE__) . '/../config/' . $config . '-test.php');

if (!$config || !file_exists($config))
{
    throw new CException('Неврный путь к конфигу') ;
}

require_once LIBRARY_PATH . 'yii/yiit.php';
require_once dirname(__FILE__) . '/WebTestCase.php';
require_once LIBRARY_PATH . 'goutte.phar';
require_once PROTECTED_PATH . 'components/ConsoleApplication.php';

$app = new ConsoleApplication($config);
