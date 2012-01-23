<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $this->meta_title; ?></title>

    <meta name="description" content="<?php echo $this->meta_description ?>"/>
    <meta name="keywords" content="<?php echo $this->meta_keywords ?>"/>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <?php
    $cs = Yii::app()->clientScript;
    $cs->registerCssFile('/css/site/style.css');
    $cs->registerCssFile('/css/admin/messages.css');
    $cs->registerCoreScript('jquery');
    $cs->registerScriptFile('/js/admin/admin_links.js');
    $cs->registerScriptFile('/js/site/cufon-yui.js');
    $cs->registerScriptFile('/js/site/arial.js');
    $cs->registerScriptFile('/js/site/cuf_run.js');
    $cs->registerScriptFile('/js/site/radius.js');
    ?>

    <script type="text/javascript">
        window.onerror = function(msg) //for selenium testing
        {
            $("body").attr("jserror", msg);
        };
    </script>

</head>
<body>
<div class="main">
    <div class="header">
        <div class="header_resize">
            <div class="menu_nav">
                <?php $this->widget('TopMenu'); ?>
            </div>
            <div class="logo">
                <h1>
                    <a href="/">YII
                        <small>CMS</small>
                    </a>
                </h1>
            </div>

            <?php $this->widget('LanguageSwitcher'); ?>

            <div class="clr"></div>
        </div>
    </div>
    <div class="content">
        <div class="content_resize">
            <div class="mainbar">
                <div class="article">
                    <h2><?php echo $this->page_title; ?></h2>

                    <?php echo $content; ?>
                </div>
            </div>
            <div class="sidebar">

                <?php $this->renderPartial('application.modules.main.views.main._search'); ?>

                <?php $this->widget('NewsSidebar'); ?>

            </div>
            <div class="clr"></div>
        </div>
    </div>
    <div class="fbg">
        <div class="fbg_resize">
            <div class="col c3">
                <?php echo PageBlock::model()->getText('contacts'); ?>
            </div>
            <div class="clr"></div>
        </div>
    </div>
    <div class="footer">
        <div class="footer_resize">
            <?php echo PageBlock::model()->getText('copyright'); ?>
            <div class="clr"></div>
        </div>
    </div>
</div>
</body>
</html>
