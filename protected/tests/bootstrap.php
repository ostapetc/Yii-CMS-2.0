<?php

$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__) . '/../../') . '/';

require_once dirname(__FILE__) . '/../config/constants.php';
require_once(LIBRARY_PATH . '/yii/yiit.php');
require_once(dirname(__FILE__).'/WebTestCase.php');

require_once(LIBRARY_PATH.'functions/debug_functions.php');
require_once(LIBRARY_PATH.'functions/php_5_3_functions.php');

Yii::createWebApplication(PROTECTED_PATH . 'config/test.php');
