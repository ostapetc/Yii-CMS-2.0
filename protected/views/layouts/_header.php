<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <?
    $cs = Yii::app()->clientScript;
    $cs->registerCoreScript('jquery');
    $cs->registerCoreScript('jquery.ui');
    Yii::app()->bootstrap->registerScripts();

    $cs->registerCssFile('/css/site/form.css');
    $cs->registerCssFile('/css/site/style.css');
    $cs->registerCssFile('/css/site/page.css');
    $cs->registerCssFile('/css/site/comments.css');
    $cs->registerCssFile('/css/site/favorites.css');
    $cs->registerCssFile('/css/site/rating.css');
    $cs->registerScriptFile('/js/site/modal-windows.js');

//    $cs->registerCssFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.css.site.styles') . '.less'));
    $cs->registerScriptFile('/js/plugins/blockUI/blockUI.js');
    $cs->registerScriptFile('/js/plugins/blockUI/loaders.js');
    if (YII_DEBUG)
    {
        $cs->registerScriptFile('/js/plugins/debug.js');
    }


    ?>

    <link rel="shortcut icon" href="/favicon.ico">

</head>

<body>

<div class="navbar navbar-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="/">Project Name</a>
            <div class="nav-collapse">
<!--                --><?// $this->widget('TopMenu'); ?>
<!--                --><?// $this->widget('TopRightMenu'); ?>
            </div>
        </div>
    </div>

    <div class="subnav">
<!--        --><?// $this->widget('TopSubMenu'); ?>
    </div>
</div>

<div class="container">
    <div class="row">