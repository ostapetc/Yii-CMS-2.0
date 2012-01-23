<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=7"/>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title><?php echo $this->page_title; ?></title>

    <style type="text/css" media="all">
            /*@import url("/css/admin/style.css");*/
            /*@import url("/css/admin/jquery.wysiwyg.css");*/
            /*@import url("/css/admin/facebox.css");*/
            /*@import url("/css/admin/visualize.css");*/
            /*@import url("/css/admin/date_input.css");*/
            /*@import url("/css/admin/messages.css");*/
            /*@import url("/css/admin/forms.css");*/
    </style>

    <link href="/css/admin/style.css" type="text/css" rel="stylesheet"/>
    <link href="/css/admin/messages.css" type="text/css" rel="stylesheet"/>
    <link href="/css/admin/forms.css" type="text/css" rel="stylesheet"/>

    <!--[if lt IE 8]>
    <style type="text/css" media="all">@import url("/css/admin/ie.css");</style>
    <![endif]-->

    <?php
    $cs = Yii::app()->clientScript;

    $cs->registerCoreScript('jquery');
    $cs->registerCoreScript('jquery.ui');
    $cs->registerScriptFile('/js/plugins/jquery.slidingmessage/jquery.slidingmessage.min.js');

    $cs->registerScriptFile('/js/plugins/blockUI/blockUI.js');
    $cs->registerScriptFile('/js/plugins/blockUI/loaders.js');
    ?>

    <script type="text/javascript">
        window.onerror = function(msg) //for selenium testing
        {
            $("body").attr("jserror", msg);
        };
    </script>

</head>
<body>
<div id="hld">

    <?php $this->renderPartial("application.modules.main.views.mainAdmin._modulesPanel"); ?>

    <div class="wrapper">
        <div id="header">
            <div class="hdrl"></div>
            <div class="hdrr"></div>

            <h1><a href="/admin">Главная</a></h1>

            <?php $this->widget('TopAdminMenu'); ?>
        </div>

        <?php $this->widget("LanguageSwitcherAdmin"); ?>

        <div class="block">
            <div class="block_head">
                <div class="bheadl"></div>
                <div class="bheadr"></div>

                <?php
                $modules = AppManager::getModulesData(true);
                $module = get_class(Yii::app()->controller->module);

                $title = $modules[$module]["name"];

                if ($this->page_title)
                {
                    $title .= " :: ".$this->page_title;
                }
                ?>

                <h2><?php echo $title; ?></h2>

                <?php if ($this->tabs): ?>
                <?php $class = "nobg"; ?>
                <ul class="tabs">
                    <?php foreach ($this->tabs as $title => $href): ?>
                    <li class="<?php echo $class ?>">
                        <a href="<?php echo $href; ?>"><?php echo $title; ?></a>
                    </li>
                    <?php $class = ""; ?>
                    <?php endforeach ?>
                </ul>
                <?php endif; ?>

            </div>

            <div style="display: block;padding-bottom:20px" class="block_content tab_content" id="tab1">
                <?php echo $content; ?>
            </div>
            <div class="bendl"></div>
            <div class="bendr"></div>
        </div>

        <div id="footer">
            <p class="left"><a href="#">cms-name.com</a></p>

            <p class="right">разработчик Остапец Артем v1.0</p>
        </div>
    </div>
</div>

<input type="hidden" id="back_url" value="<?php echo base64_encode($_SERVER["REQUEST_URI"]); ?>"/>

</body>
</html>



<!--[if IE]>
<!--<script type="text/javascript" src="/js/admin/excanvas.js"></script><![endif]-->
<!--<script type="text/javascript" src="/js/admin/jquery_007.js"></script>-->
<!--<script type="text/javascript" src="/js/admin/jquery_006.js"></script>-->
<!--<script type="text/javascript" src="/js/admin/jquery_008.js"></script>-->
<!--<script type="text/javascript" src="/js/admin/jquery_002.js"></script>-->
<!--<script type="text/javascript" src="/js/admin/jquery_009.js"></script>-->
<!--<script type="text/javascript" src="/js/admin/facebox.js"></script>-->

<!--<script type="text/javascript" src="/js/admin/jquery_010.js"></script>-->
<!--<script type="text/javascript" src="/js/admin/jquery_005.js"></script>-->
<!--<script type="text/javascript" src="/js/admin/jquery_004.js"></script>-->
<!--<script type="text/javascript" src="/js/admin/ajaxupload.js"></script>-->
<!--<script type="text/javascript" src="/js/admin/jquery_003.js"></script>-->
<!--<script type="text/javascript" src="/js/admin/custom.js"></script>-->

