<?
ini_set("display_errors", 1);
error_reporting(E_ALL);
ini_set('xdebug.max_nesting_level', 1000);
date_default_timezone_set('Europe/Moscow');

define('DS', DIRECTORY_SEPARATOR);

$_SERVER['DOCUMENT_ROOT'] = str_replace(array('\\', '/'), DS, $_SERVER['DOCUMENT_ROOT']);

if (substr($_SERVER['DOCUMENT_ROOT'], -1) != DS)
{
    $_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'] . DS;
}

require_once $_SERVER['DOCUMENT_ROOT'] . 'protected' . DS . 'config' . DS . 'constants.php';
require_once LIBRARIES_PATH . 'yii' . DS . 'yii.php';
require_once LIBRARIES_PATH . 'functions.php';

$env = YII_DEBUG ? 'development' : 'production';
defined('ENV') || define('ENV', $env);

if (ENV !== 'production')
{
    require_once LIBRARIES_PATH . 'debug.php';
}

$config = APP_PATH . 'config' . DS . ENV .'.php';

Yii::createWebApplication($config)->run();

//Page::model()->deleteAll('id <> 35');
//
//$page = Page::model()->findByPk(35);
//
//for ($i = 0; $i < 20; $i ++)
//{
//    $_POST['Page']['tags'] = 'Тег1,Тег2';
//
//    $p = new Page();
//    $p->user_id = $page->user_id;
//    $p->title = $page->title;
//    $p->text = $page->text;
//    $p->status = Page::STATUS_PUBLISHED;
//    $p->save();
//}
//

//PageSectionRel::model()->deleteAll();
//
//$pages = Page::model()->findAll();
//$sections = PageSection::model()->findAll();
//
//foreach ($pages as $page)
//{
//    foreach ($sections as $section)
//    {
//        $rel = new PageSectionRel();
//        $rel->page_id = $page->id;
//        $rel->section_id = $section->id;
//        $rel->save();
//    }
//}