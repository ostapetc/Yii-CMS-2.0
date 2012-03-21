<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $this->meta_title ?></title>
    <meta name="keywords" content="<?= $this->meta_keywords ?>">
    <meta name="description" content="<?= $this->meta_description ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="/css/site/bootstrap.css" rel="stylesheet">
    <link href="/css/site/bootstrap-responsive.css" rel="stylesheet">
    <link href="/css/site/main.css" rel="stylesheet">

    <?php
    Yii::app()->clientScript->registerCoreScript('jquery');
    ?>

<!--    <script type="text/javascript" src="/js/site/jquery-1.7.1.min.js"></script>-->
    <script type="text/javascript" src="/js/site/bootstrap-dropdown.js"></script>


    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }

        .sidebar-nav {
            padding: 9px 0;
        }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <!--<link rel="shortcut icon" href="images/favicon.ico">-->
    <!--<link rel="apple-touch-icon" href="images/apple-touch-icon.png">-->
    <!--<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">-->
    <!--<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">-->

    <?php
    $settings   = Setting::model()->findCodesValues('main');
    $site_width = (int) $settings['SITE_WIDTH'];
    $c_class    = $site_width > 0 ? 'container' : 'container-fluid';
    $menu_bg    = explode(',', $settings['TOP_MENU_BACKGROUND']);
    //$con_class =
    ?>

    <style type="text/css">
        body {
            background-color: <?php echo $settings['SITE_BACKGROUD']; ?>
        }

        .navbar-inner {
            background-color: <?php echo $menu_bg[0]; ?>;
            background-image: -moz-linear-gradient(top, <?php echo $menu_bg[1]; ?>, <?php echo $menu_bg[2]; ?>);
            background-image: -ms-linear-gradient(top, <?php echo $menu_bg[1]; ?>, <?php echo $menu_bg[2]; ?>);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(<?php echo $menu_bg[1]; ?>), to(<?php echo $menu_bg[2]; ?>));
            background-image: -webkit-linear-gradient(top, <?php echo $menu_bg[1]; ?>, <?php echo $menu_bg[2]; ?>);
            background-image: -o-linear-gradient(top, <?php echo $menu_bg[1]; ?>, <?php echo $menu_bg[2]; ?>);
            background-image: linear-gradient(top, <?php echo $menu_bg[1]; ?>, <?php echo $menu_bg[2]; ?>);
        }

        .navbar .nav .active > a, .navbar .nav .active > a:hover {
            background-color: <?php echo $menu_bg[2]; ?>;
        }

        .navbar .nav > li > a {
            color: <?php echo $settings['TOP_MENU_LINK_COLOR']; ?>;
        }

        .navbar .nav > li > a:hover {
            color: <?php echo $settings['TOP_MENU_LINK_COLOR_HOOVER']; ?>;
        }

        .navbar .nav .active > a, .navbar .nav .active > a:hover {
            color: <?php echo $settings['TOP_MENU_LINK_COLOR_HOOVER']; ?>;
        }

        .well {
            background-color: <?php echo $settings['SIDEBAR_BACKGROUND']; ?>;
        }

        h1 {
            font-size: <?= $settings['H1_SIZE']; ?>px !important;
            color: <?= $settings['H1_COLOR']; ?> !important;
        }

        <?php if ($site_width): ?>
            .span12, .container {
                width: <?php echo $site_width; ?>px;
            }
        <?php endif ?>
    </style>

</head>


<body>

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="<?php echo $c_class; ?>">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="/">
                <? if ($path = Setting::getValue('LOGO')): ?>
                    <?= CHtml::image($path); ?>
                <? endif ?>
            </a>

            <div class="nav-collapse">
                <?php $this->widget('TopMenu'); ?>
                <? $languages = Language::getCachedArray(); ?>
                <? foreach ($languages as $id => $name): ?>
                    <a class="brand" style="float: right;padding-right: 0 !important;padding-left: 30px !important;" href="/<?= $id ?>" title="<?= t($name) ?>"><img src="/img/icons/<?= $id; ?>.png" /></a>
                <? endforeach ?>
            </div>
        </div>
    </div>
</div>

<div class="<?php echo $c_class; ?>">
    <div class="row-fluid">

        <?php if (is_numeric($this->left_menu_id)): ?>
            <div class="span3">
                <?php $this->widget('LeftMenu', array('left_menu_id' => $this->left_menu_id)); ?>

                <?php $this->widget('Sidebars'); ?>
            </div>
        <?php endif ?>

        <div class="span9">
            <?php if ($settings['SHOW_BREAD_CRUMBS'] && !$this->isRootUrl()): ?>
                <?php $this->widget('BootCrumb', array('links' => $this->crumbs,)); ?>
            <?php endif ?>

            <?php if (!$this->isRootUrl()): ?>
                <h1><?php echo $this->page_title; ?></h1>
            <?php endif ?>

            <?php echo $content; ?>
        </div>
    </div>

    <hr>

    <footer>
        <?php echo PageBlock::model()->language()->getText('FOOTER'); ?>
    </footer>

</div>

<!--<script src="/js/site/bootstrap-transition.js"></script>-->
<!--<script src="/js/site/bootstrap-alert.js"></script>-->
<!--<script src="/js/site/bootstrap-modal.js"></script>-->
<!--<script type="text/javascript" src="/js/site/bootstrap-dropdown.js"></script>-->
<!--<script src="/js/site/bootstrap-scrollspy.js"></script>-->
<!--<script src="/js/site/bootstrap-tab.js"></script>-->
<!--<script src="/js/site/bootstrap-tooltip.js"></script>-->
<!--<script src="/js/site/bootstrap-popover.js"></script>-->
<!--<script src="/js/site/bootstrap-button.js"></script>-->
<!--<script src="/js/site/bootstrap-collapse.js"></script>-->
<!--<script src="/js/site/bootstrap-carousel.js"></script>-->
<!--<script src="/js/site/bootstrap-typeahead.js"></script>-->

</body>
</html>
