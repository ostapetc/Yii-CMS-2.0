<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>Yii CMS Admin Panel</title>

    <?
    $base = Yii::app()->baseUrl;

    $cs = Yii::app()->clientScript;
    $cs->registerCoreScript('jquery');
    $cs->registerCoreScript('jquery.ui');
    Yii::app()->bootstrap->registerScripts();
    $cs->registerCssFile($base.'/css/admin/layout.css');
    $cs->registerCssFile($base.'/css/admin/form.css');
    $cs->registerCssFile($base.'/css/icons.css');
    $cs->registerCssFile($base.'/css/admin/extend.css');
    $cs->registerScriptFile($base.'/js/admin/hideshow.js');
    $cs->registerScriptFile($base.'/js/admin/jquery.tablesorter.min.js');
    $cs->registerScriptFile($base.'/js/admin/jquery.equalHeight.js');
    $cs->registerScriptFile($base.'/js/admin/jquery.hotkeys.js');
    $cs->registerScriptFile($base.'/js/admin/jquery.console.js');
    $cs->registerScriptFile($base.'/js/admin/main.js');
    $cs->registerScriptFile($base.'/js/plugins/hint.js');
    Yii::app()->bootstrap->registerModal();
    ?>

    <!--[if lt IE 9]>
    <link rel="stylesheet" href="/css/admin/ie.css" type="text/css" media="screen"/>
    <script src="/js/admin/html5.js"></script>
    <![endif]-->
</head>