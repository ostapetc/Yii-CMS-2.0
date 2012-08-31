<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><? echo $this->meta_title ?></title>
    <meta name="description" content="<? echo $this->meta_description ?>">
    <meta name="keywords" content="<? echo $this->meta_keywords ?>">
    <meta name="author" content="">

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <?
    $cs = Yii::app()->clientScript;
    $cs->registerCoreScript('jquery');
//    $cs->registerCoreScript('jquery.ui');
    Yii::app()->bootstrap->registerScripts();

    $cs->registerCssFile('/css/site/form.css');
    $cs->registerCssFile('/css/site/style.css');
    $cs->registerCssFile('/css/site/menu.css');
    $cs->registerCssFile('/css/site/page.css');
    $cs->registerCssFile('/css/site/comments.css');
    $cs->registerCssFile('/css/site/favorites.css');
    $cs->registerCssFile('/css/site/rating.css');
    $cs->registerScriptFile('/js/site/modal-windows.js');

//    $cs->registerCssFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.css.site.styles') . '.less'));
//    $cs->registerCssFile((Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css'));
//    $cs->registerScriptFile('/js/plugins/modal/bootstrap-modal.js');
//    $cs->registerCssFile('/js/plugins/modal/modal.css');
//    $cs->registerScriptFile('/js/plugins/blockUI/blockUI.js');
//    $cs->registerScriptFile('/js/plugins/blockUI/loaders.js');
//    $cs->registerScriptFile('/js/plugins/bootstrap/bootstrap-modal.js');
//    if (YII_DEBUG)
//    {
//        $cs->registerScriptFile('/js/plugins/debug.js');
//    }


    ?>

    <link rel="shortcut icon" href="/favicon.ico">

</head>

<body>

<div id='main-wrapper'>
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
                    <? $this->widget('TopMenu'); ?>
<!--                    --><?// $this->widget('TopRightMenu'); ?>
                </div>
            </div>
        </div>

        <div class="subnav">
            <? //$this->widget('TopSubMenu'); ?>
        </div>

        <br clear="all" />
    </div>

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span8 well">
                <? if ($this->page_title): ?>
                <h1><?= $this->page_title ?></h1>
                <? endif ?>

                <?= $content ?>
            </div>
            <!--/span-->
            <div class="span4">
                <?= $this->widget('SidebarManager') ?>
            </div>
        </div>
        <hr>

        <footer>
            <p>&copy; Company 2012</p>
        </footer>
    </div>

</div>
