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
    $cs->registerCoreScript('jquery.ui');
    Yii::app()->bootstrap->registerScripts();
    $cs->registerCssFile('/css/site/form.css');
    $cs->registerCssFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.css.site.styles').'.less'));
    $cs->registerCssFile((Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css'));

    if (YII_DEBUG)
    {
        $cs->registerScriptFile('/js/plugins/debug.js');
    }
    ?>
<!--    <script type="text/javascript">-->
<!--        $(document).ready(function()-->
<!--        {-->
<!--            $('.modal').appendTo('body');-->
<!---->
<!--            $('a[data-toggle=tab][data-url]').on('shown', function(e)-->
<!--            {-->
<!--                var tab = $(e.target); // activated tab-->
<!--                $(tab.attr('href')).load(tab.data('url'));-->
<!--                e.relatedTarget // previous tab-->
<!--            });-->
<!---->
<!--        });-->
<!--    </script>-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/favicon.ico">
<!--    <link rel="apple-touch-icon" href="/apple-touch-icon.png">-->
<!--    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">-->
<!--    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">-->
</head>

<body>

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="/">Yii-CMS 2.0</a>

            <div class="nav-collapse">
                <? $this->widget('TopMenu'); ?>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row-fluid">