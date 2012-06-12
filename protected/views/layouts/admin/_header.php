<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>Yii CMS Admin Panel</title>

    <?
    $cs = Yii::app()->clientScript;
    $cs->registerCoreScript('jquery');
    $cs->registerCoreScript('jquery.ui');
    Yii::app()->bootstrap->registerScripts();
    $cs->registerCssFile('/css/admin/layout.css');
    $cs->registerCssFile('/css/admin/form.css');
    $cs->registerCssFile('/css/icons.css');
    $cs->registerCssFile('/css/admin/extend.css');
    $cs->registerScriptFile('/js/admin/hideshow.js');
    $cs->registerScriptFile('/js/admin/jquery.tablesorter.min.js');
    $cs->registerScriptFile('/js/admin/jquery.equalHeight.js');
    $cs->registerScriptFile('/js/admin/jquery.hotkeys.js');
    $cs->registerScriptFile('/js/admin/jquery.console.js');
    $cs->registerScriptFile('/js/admin/main.js');
    $cs->registerScriptFile('/js/plugins/hint.js');
    Yii::app()->bootstrap->registerModal();
    ?>

    <!--[if lt IE 9]>
    <link rel="stylesheet" href="/css/admin/ie.css" type="text/css" media="screen"/>
    <script src="/js/admin/html5.js"></script>
    <![endif]-->
</head>