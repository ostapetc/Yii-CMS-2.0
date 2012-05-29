<?php
require_once dirname(__FILE__) . '/../../../config/constants.php';
require_once(LIBRARIES_PATH . '/yii/yiit.php');
require_once(dirname(__FILE__).'/WebTestCase.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/WebApplication.php');

//require_once(LIBRARY_PATH.'functions/debug_functions.php');
//require_once(LIBRARY_PATH.'functions/php_5_3_functions.php');

$config = realpath(dirname(__FILE__) . '/../config/test.php');
$app = Yii::createWebApplication($config);

//run modules->init();
foreach ($app->getModules() as $id => $config)
{
    $app->getModule($id);
}