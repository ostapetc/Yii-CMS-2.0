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
    $base = Yii::app()->baseUrl;

    $cs = Yii::app()->clientScript;
    $cs->registerCoreScript('jquery');
    Yii::app()->bootstrap->registerScripts();

    $cs->registerScriptFile('/js/coreFunctions.js');

    $cs->registerCssFile($base . '/css/icons.css');
    $cs->registerCssFile($base . '/css/site/form.css');
    $cs->registerCssFile($base . '/css/site/style.css');
    $cs->registerCssFile($base . '/css/site/menu.css');
    $cs->registerCssFile($base . '/css/site/page.css');
    $cs->registerCssFile($base . '/css/site/comments.css');
    $cs->registerCssFile($base . '/css/site/favorites.css');
    $cs->registerCssFile($base . '/css/site/rating.css');
    $cs->registerScriptFile($base.'/js/plugins/clip/ZeroClipboard.min.js');
    $cs->registerScriptFile($base.'/js/site/clip.js');
    $cs->registerScriptFile($base . '/js/site/modal-windows.js');

    #toasmessage plugin, message notifier
    $cs->registerScriptFile('/js/plugins/toastmessage/javascript/jquery.toastmessage.js');
    $cs->registerCssFile('/js/plugins/toastmessage/resources/css/jquery.toastmessage.css');

    $cs->registerScriptFile('/js/plugins/errorsNotifier.js');

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

<body class="iframe">

<? $this->renderPartial('application.views.layouts._modal'); ?>
<?= $content ?>
</body>
</html>
