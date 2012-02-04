<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>Yii CMS Admin Panel</title>

    <?php
    $cs = Yii::app()->clientScript;
    $cs->registerCoreScript('jquery');
    $cs->registerCoreScript('jquery.ui');
    $cs->registerCssFile('/css/admin/layout.css');
    $cs->registerScriptFile('/js/admin/hideshow.js');
    $cs->registerScriptFile('/js/admin/jquery.tablesorter.min.js');
    $cs->registerScriptFile('/js/admin/jquery.equalHeight.js');
    ?>

    <!--[if lt IE 9]>
    <link rel="stylesheet" href="/css/admin/ie.css" type="text/css" media="screen"/>
    <script src="/js/admin/html5.js"></script>
    <![endif]-->
</head>


<body>
    <header id="header">
        <hgroup>
            <h1 class="site_title"><a href="/admin">Yii CMS</a></h1>

            <h2 class="section_title">Админ панель</h2>

            <div class="btn_view_site"><a href="/">На сайт</a></div>
        </hgroup>
    </header>

    <section id="secondary_bar">
        <div class="user">
            <p>
                <?php echo Yii::app()->user->model->full_name; ?>
                <a href="<?php echo $this->createUrl('/users/user/logout'); ?>" class="underline float_right">Выйти</a>
            </p>
        </div>
        <div class="breadcrumbs_container">
            <?php
            $this->widget('zii.widgets.CBreadcrumbs', array(
                'links'     => $this->crumbs,
                'separator' => '<div class="breadcrumb_divider"></div>',
                'tagName'   => 'article',
                'homeLink'  => '<a href="/admin">Админ панель</a>'
            ));
            ?>
        </div>
    </section>

    <aside id="sidebar" class="column">
        <?php $this->renderPartial('application.modules.main.views.mainAdmin._search'); ?>
        <hr/>
        <?php $this->widget('AdminMenu'); ?>

        <footer>
            <hr/>
            <p><strong>Copyright &copy; 2011 Website Admin</strong></p>

            <p>Theme by <a href="http://www.medialoot.com">MediaLoot</a></p>
        </footer>
    </aside>

    <section id="main" class="column">
        <div class="clear"></div>
            <article class="module width_full">
                <header>
                    <h3 class="tabs_involved"><?php echo $this->page_title; ?></h3>
                    <?php if (is_array($this->tabs)): ?>
                        <ul class="tabs">
                            <?php foreach ($this->tabs as $title => $url): ?>
                                <li>
                                    <a href="<?php echo $url; ?>"><?php echo $title; ?></a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    <?php endif ?>
                </header>

                <?php echo $content; ?>

                <?php if ($this->footer): ?>
                    <footer><?php echo $this->footer; ?></footer>
                <?php endif ?>
            </article>
        <div class="spacer"></div>
    </section>
</body>

<div id="T"
     data-hide="Скрыть"
     data-show="показать"
        >
</div>

</html>