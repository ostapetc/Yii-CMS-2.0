<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Bootstrap, from Twitter</title>
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

    $cs->registerCoreScript('jquery');
    $cs->registerScriptFile('/js/plugins/bootstrap/js/bootstrap.js');
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
//            $('.dropdown-toggle').dropdown();
            //            $('#login').modal();
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
                    <li>
                        <a data-toggle="modal" href="#login">Login</a>
                    </li>
                </ul>
                </li>
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
            <!--/.well -->
        </div>
        <!--/span-->
        <div class="span9">
            <?php echo $content ?>
        </div>
        <!--/span-->
    </div>
    <!--/row-->

    <hr>

    <footer>
        <p>&copy; Company 2012</p>
    </footer>

</div>
<!--/.fluid-container-->


<div class="modal hide fade" id="login">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>

        <h3>Вход</h3>
    </div>
    <div class="modal-body">
        <?php $this->widget('users.portlets.LoginPanel') ?>
    </div>
    <div class="modal-footer">
<!--        <a href="#" class="btn btn-primary">Save changes</a>-->
<!--        <a href="#" class="btn">Close</a>-->
    </div>
</div>

</body>
</html>
