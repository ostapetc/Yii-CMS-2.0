<?
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__) . '/../../') . '/';

require_once dirname(__FILE__) . '/../config/constants.php';
require_once LIBRARIES_PATH . '/yii/yiit.php';
require_once dirname(__FILE__).'/WebTestCase.php';
require_once LIBRARIES_PATH.'functions.php';

Yii::createWebApplication(APP_PATH . 'config/test.php');
