<?
ini_set("display_errors", 1);
error_reporting(E_ALL);
ini_set('xdebug.max_nesting_level', 1000);

date_default_timezone_set('Europe/Moscow');

$_SERVER['DOCUMENT_ROOT'] = str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, $_SERVER['DOCUMENT_ROOT']);

if (substr($_SERVER['DOCUMENT_ROOT'], -1) != DIRECTORY_SEPARATOR)
{
    $_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR;
}

require_once $_SERVER['DOCUMENT_ROOT'] . 'protected' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'constants.php';
require_once LIBRARIES_PATH . 'yii' . DS . 'yii.php';
require_once LIBRARIES_PATH . 'functions.php';
require_once LIBRARIES_PATH . 'debug.php';

$config = APP_PATH . 'config' . DS . (defined('ENV') ? ENV : CONFIG) .'.php';

Yii::createWebApplication($config)->run();

//$sections = PageSection::model()->forum()->findAll();
//foreach ($sections as $i => $section)
//{
//    for ($k = 0; $k < 5; $k++)
//    {
//        $page = new Page();
//        $page->user_id = 1;
//        $page->title   = 'Топик ' . $i . $k;
//        $page->text    = "Текст топика " . $i . $k;
//        $page->status  = Page::STATUS_PUBLISHED;
//        $page->save();
//
//        $rel = new PageSectionRel();
//        $rel->section_id = $section->id;
//        $rel->page_id    = $page->id;
//        $rel->save();
//    }
//}