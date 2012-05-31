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
require_once LIBRARIES_PATH . 'debug.php';

$env = YII_DEBUG ? 'development' : 'production';
defined('ENV') || define('ENV', $env);
defined('CONFIG') || define('CONFIG', $env);

$config = APP_PATH . 'config' . DS . CONFIG .'.php';

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


//$root = new Comment();
//
//$root = new Comment();
//$root->text      = time();
//$root->user_id   = 1;
//$root->object    = 'Page_35';
//$root->saveNode();
//
//for ($i = 0; $i < 5; $i++)
//{
//    $comment = new Comment();
//    $comment->text      = 'ch ' . $i;
//    $comment->user_id   = 1;
//    $comment->object    = 'Page_35';
//    $comment->appendTo($root);
//
//    for ($k = 0; $k < 3; $k++) {
//        $s_comment = new Comment();
//        $s_comment->text      = 'ch 1' . $i . $k;
//        $s_comment->user_id   = 1;
//        $s_comment->object    = 'Page_35';
//        $s_comment->appendTo($comment);
//    }
//}


//$comments = Comment::model()->findAllByAttributes(array('root' => 9), array('order' => '`left`'));
//foreach ($comments as $comment)
//{
//    echo "<div style='padding-left: " . (10 * $comment->level) . "px'>{$comment->text}</div>";
//}