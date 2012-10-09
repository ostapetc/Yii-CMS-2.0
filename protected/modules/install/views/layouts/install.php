<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><? echo $this->meta_title ?></title>
    <meta name="description" content="<? echo $this->meta_description ?>">
    <meta name="keywords" content="<? echo $this->meta_keywords ?>">
    <meta name="author" content="">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <?
    $cs = Yii::app()->clientScript;
    $cs->registerCoreScript('jquery');
    Yii::app()->bootstrap->registerScripts();
    $cs->registerCssFile('/css/site/form.css');
    $cs->registerScriptFile('/js/plugins/hint.js');

    $cs->registerCssFile(
        Yii::app()->assetManager->publish(Yii::getPathOfAlias('install.assets.css.install') . '.less')
    );

    if (YII_DEBUG) {
        $cs->registerScriptFile('/js/plugins/debug.js');
    }
    ?>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.modal').appendTo('body');

            $('a[data-toggle=tab][data-url]').on('shown', function (e) {
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
<div class="container">
    <div class="navbar navbar-top install-top-menu">
        <div class="navbar-inner">
            <div class="container-fluid">
                <a class="brand" href="/install.php">Yii-CMS 2.0 Установка</a>

                <div class="nav-collapse">
                    <ul class="nav">
                        <li><a href="#">Начало</a></li>
                        <li><a href="#">Шаг 1</a></li>
                        <li><a href="#">Шаг 2</a></li>
                        <li><a href="#">Шаг 3</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid content">
        <?
        foreach(Yii::app()->user->getFlashes() as $key => $msg) {
            echo Yii::app()->controller->msg($msg, $type);
        }
        ?>
        <?= $content ?>
    </div>
    <hr>

    <footer>
        <p>Install</p>
    </footer>
</div>
</body>
</html>
