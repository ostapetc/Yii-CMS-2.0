<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>Yii CMS Admin Panel</title>

    <?
    $cs = Yii::app()->clientScript;
    $cs->registerCoreScript('jquery');
    $cs->registerCoreScript('jquery.ui');
    Yii::app()->bootstrap->registerScripts();
    $cs->registerCssFile('/css/admin/layout.css');
    $cs->registerCssFile('/css/admin/form.css');
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
</head>


<body>
    <header id="header">
        <hgroup>
            <h1 class="site_title" ><a href="/admin" style="margin-left: 20px"><?= Param::get('project_name'); ?></a></h1>

            <h2 class="section_title" style="padding-left: 24px;"><? echo t($this->module->name()); ?></h2>

            <div class="btn_view_site"><a href="/"><? echo t('На сайт'); ?></a></div>

            <div style="float: right;margin-right:20px"><? $this->widget('LanguageSwitcherAdmin'); ?></div>

        </hgroup>
    </header>

    <section id="secondary_bar">
        <div class="user">
            <p>
                <?
                $user_name = Yii::app()->user->model->full_name;
                if (mb_strlen($user_name, 'utf-8') > 13)
                {
                    $user_name = mb_substr($user_name, 0, 13, 'utf-8') . '...';
                }
                ?>

                <?= $user_name ?>
                <a href="<? echo $this->createUrl('/users/user/logout'); ?>" class="underline float_right"><? echo t('Выйти'); ?></a>
            </p>
        </div>
        <div class="breadcrumbs_container">
            <?
            Yii::app()->clientScript->registerScript(
                'CBreadcrumbs',
                '$(".breadcrumbs a").last().addClass("current")'
            );

            $this->widget('zii.widgets.CBreadcrumbs', array(
                'links'     => $this->crumbs,
                'separator' => '<div class="breadcrumb_divider"></div>',
                'tagName'   => 'article',
                'homeLink'  => '<a href="/content/pageAdmin/manage">' . t("Панель управления") . '</a>'
            ));
            ?>
        </div>
    </section>

    <aside id="sidebar" class="column">
        <? $this->renderPartial('main.views.mainAdmin._search'); ?>
        <hr/>
        <? $this->widget('AdminMenu'); ?>

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
                    <h3 class="tabs_involved"><? echo $this->page_title; ?></h3>
                    <? if (is_array($this->tabs)): ?>
                        <ul class="tabs">
                            <? foreach ($this->tabs as $title => $url): ?>
                                <li>
                                    <a href="<? echo $url; ?>" class="btn btn-success tabs"><? echo $title; ?></a>
                                </li>
                            <? endforeach ?>
                        </ul>
                    <? endif ?>
                </header>

                <div style="padding: 10px!important;">
                    <? foreach (Yii::app()->user->getFlashes() as $type => $message): ?>
                        <?= $this->msg($message, $type); ?>
                    <? endforeach ?>

                    <? echo $content; ?>
                </div>


                <? if ($this->footer): ?>
                    <footer><? echo $this->footer; ?></footer>
                <? endif ?>
            </article>
        <div class="spacer"></div>
    </section>
</body>

<div id="T"
     data-hide="<? echo t('Скрыть'); ?>"
     data-show="<? echo t('показать'); ?>"
        >
</div>

</html>