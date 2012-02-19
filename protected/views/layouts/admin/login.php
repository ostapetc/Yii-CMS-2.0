<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>Yii CMS Admin Panel</title>

    <?php
    $cs = Yii::app()->clientScript;
    $cs->registerCoreScript('jquery.ui');
    $cs->registerCssFile('/css/admin/layout.css');
    $cs->registerCssFile('/css/admin/extend.css');
    $cs->registerScriptFile('/js/admin/hideshow.js');
    $cs->registerScriptFile('/js/admin/jquery.tablesorter.min.js');
    $cs->registerScriptFile('/js/admin/jquery.equalHeight.js');
    $cs->registerScriptFile('/js/admin/main.js');
    ?>

    <!--[if lt IE 9]>
    <link rel="stylesheet" href="/css/admin/ie.css" type="text/css" media="screen"/>
    <script src="/js/admin/html5.js"></script>
    <![endif]-->

    <style type="text/css">
        .middle_div
        {
           position: absolute;
           width: 470px;
           left: 50%;
           top: 50%;
           margin-left: -235px;
           margin-top: -200px;
           border: 1px solid #C0C0C0 !important;
        }
    </style>
</head>


<body>
    <header id="header">
        <hgroup>
            <h2 class="section_title" style="width: 100%"><?php echo t('Авторизация в админ панель'); ?></h2>
        </hgroup>
    </header>

    <article class="module middle_div">
        <div style="padding: 10px!important;">
            <?php echo $content; ?>
        </div>
        <?php if ($this->footer): ?>
            <footer><?php echo $this->footer; ?></footer>
        <?php endif ?>
    </article>
</body>

</html>