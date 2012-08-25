<? $this->renderPartial('application.views.layouts.admin._header'); ?>


<body>
    <input type="hidden" id="current_url" value="<?= base64_encode($_SERVER['REQUEST_URI']) ?>">

    <?= $this->renderPartial('application.views.layouts.admin._modal'); ?>

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
                $user_name = Yii::app()->user->model->name;
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