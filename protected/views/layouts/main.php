<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <?php
    $cs = Yii::app()->clientScript;
    $cs->registerCssFile('/js/plugins/bootstrap/css/bootstrap.css');
    $cs->registerCssFile('/js/plugins/bootstrap/css/bootstrap-responsive.css');

    $cs->registerCssFile('/css/site/extend.css');

    $cs->registerCoreScript('jquery');
    $cs->registerScriptFile('/js/plugins/bootstrap/js/bootstrap.js');

    if (YII_DEBUG)
    {
        $cs->registerScriptFile('/js/plugins/debug.js');
    }
    ?>
    <style type="text/css">
        body{
            padding-top:    60px;
            padding-bottom: 40px;
        }
        .sidebar-nav{
            padding: 9px 0;
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function()
        {
            $('.modal').appendTo('body');

            $('a[data-toggle=tab][data-url]').on('shown', function(e)
            {
                var tab = $(e.target); // activated tab
                $(tab.attr('href')).load(tab.data('url'));
                e.relatedTarget // previous tab
            });

        });
    </script>

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
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
                <?php $this->widget('TopMenu') ?>

                <p class="navbar-text pull-right">
                    <?php $this->widget('main.portlets.LanguageSwitcher') ?>
                </p>

                <p class="navbar-text pull-right divider-vertical"></p>

                <ul class="nav pull-right">
                    <?php $this->widget('users.portlets.LoginPanel') ?>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <div class="well sidebar-nav">
                <?php $this->widget('SidebarMenu') ?>
            </div>
            <?php $this->widget('SidebarBanners') ?>
        </div>
        <div class="span9">
            <?php echo $content ?>
        </div>
    </div>
    <hr>

    <footer>
        <p>&copy; Company 2012</p>
    </footer>

</div>


</body>
</html>
