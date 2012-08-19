<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->meta_title; ?></title>

<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>


<!--стили сайта-->
<link rel="stylesheet" type="text/css" href="<?= $this->module->assetsUrl() ?>/css/style.css"/>

<!--стили навигаторов-->
<link rel="stylesheet" type="text/css" href="<?= $this->module->assetsUrl() ?>/css/site/alphapager.css"/>
<link rel="stylesheet" type="text/css" href="<?= $this->module->assetsUrl() ?>/css/site/pager.css"/>

<!--стили форм-->
<!--<link rel="stylesheet" type="text/css" href="/css/site/form.css"/>-->

<!--стили виджетов-->
<link rel="stylesheet" type="text/css" href="<?= $this->module->assetsUrl() ?>/css/site/gridview/styles.css"/>
<link rel="stylesheet" type="text/css" href="<?= $this->module->assetsUrl() ?>/css/site/detailview/styles.css"/>
<link rel="stylesheet" type="text/css" href="<?= $this->module->assetsUrl() ?>/css/site/listview/styles.css"/>

<?php Yii::app()->clientScript->registerCoreScript('jquery') ?>

</head>
<body>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#toogle-menu a').click(function()
        {
            $('#header').slideToggle(400);
        });
    });
</script>
<div>
    <?php

    $conventions  = array(
        'Стандарты именования и кодирования'=> '/conventions/naming',
        'Структура директорий'              => '/conventions/directoryStructure',
        'Написание основных компонентов'    => '/conventions/mvc',
        'Совместная работа над проектом'    => '/conventions/cooperation',
    );

    $main_themes  = array(
        'ActiveRecordModel' => '/mainThemes/activeRecordModel',
        'GridView'          => '/mainThemes/gridView',
    );
    $modules      = array(
        'main'                           => '/main',
        'content - Контент'              => '/content',
//        'products - Каталог продуктов'   => '/products',
//        'orders - Заказы'                => '/orders',
        'fileManager - Файловый менеджер'=> '/fileManager',
        'glossary'                       => '/glossary',
    );
    ksort($modules);
    $behaviors = array(
        'componentInModule' => '/behaviors/componentInModule',
        'metaTags'          => '/behaviors/metaTags',
    );
    ksort($behaviors);

    $app_components = array(
        'dater'      => '/applicationComponents/dater',
        'text'       => '/applicationComponents/text',
    );
    ksort($app_components);
    $special = array(
        'Виджеты для форм' => '/special/formWidgets',
    );
    ksort($special);

    function show_menu($name, $data)
    {
        echo CHtml::tag('h3', array(), $name);
        echo '<ul>';
        foreach ($data as $key => $val)
        {
            echo '<li>';
            $data = $val == '' ? array('class' => 'no-complete') : array();
            echo CHtml::link($key, '/docs/base'.$val, $data);
            echo '</li>';
        }
        echo '</ul>';
    }
    ?>
    <div id="header">
        <table style="width: 98%;" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td>
                    <?php show_menu('Соглашения', $conventions) ?>
                </td>
                <td class="sep">
                    <?php show_menu('Общие темы', $main_themes) ?>
                    <?php show_menu('Поведения', $behaviors) ?>
                    <?php show_menu('Компоненты приложения', $app_components) ?>
                </td>
                <td class="sep">
                    <?php show_menu('Модули', $modules) ?>
                </td>
                <td class="sep">
                    <?php show_menu('Специальные темы', $special) ?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div id="toogle-menu">
        <a href="#">
            <img src="<?= $this->module->assetsUrl() ?>/images/nav_toggle.jpg" width="153" height="44" border="0" title="Содержание" alt="Содержание">
        </a>
    </div>
    <div id="content">
        <?php echo $content ?>
    </div>
</div>
</body>
</html>
