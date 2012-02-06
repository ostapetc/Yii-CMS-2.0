<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->meta_title; ?></title>

<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>


<!--стили сайта-->
<link rel="stylesheet" type="text/css" href="/css/style.css"/>

<!--стили навигаторов-->
<link rel="stylesheet" type="text/css" href="/css/site/alphapager.css"/>
<link rel="stylesheet" type="text/css" href="/css/site/pager.css"/>

<!--стили форм-->
<!--<link rel="stylesheet" type="text/css" href="/css/site/form.css"/>-->

<!--стили виджетов-->
<link rel="stylesheet" type="text/css" href="/css/site/gridview/styles.css"/>
<link rel="stylesheet" type="text/css" href="/css/site/detailview/styles.css"/>
<link rel="stylesheet" type="text/css" href="/css/site/listview/styles.css"/>

<?php Yii::app()->clientScript->registerCoreScript('jquery') ?>

<style type="text/css">
    /*
    yiiext CSS
    Alexander Makarov, sam@rmcreative.ru
    */
body{
    font:       normal 10pt Arial, Helvetica, sans-serif;
    background: #fff;
    color:      #555;
    text-align: left;
}

a, a:visited{
    color:           #306495;
    text-decoration: none;
}

a:hover{
    color:           #73471b;
    text-decoration: underline;
}

h1, h2, h3, h4, h5, h6{
    font-weight: bold;
    font-family: Calibri, Helvetica, Arial, sans-serif;
}
blockquote{
    background: #FBE6F2;
    border:     1px solid #D893A1;
    color:      #333;
    margin:     10px 0 5px 0;
    padding:    10px;
}
h1{
    font-size: 1.6em;
    margin:    1em 0 .5em;
}

h2{
    font-size: 1.5em;
    margin:    1.07em 0 .535em;
}

h3{
    font-size: 1.4em;
    margin:    1.14em 0 .57em;
}

h4{
    font-size: 1.3em;
    margin:    1.23em 0 .615em;
}

h5{
    font-size: 1.2em;
    margin:    1.33em 0 .67em;
}

h6{
    font-size: 1.1em;
    margin:    1.6em 0 .8em;
}

strong{
    font-weight: bold;
}

table{
    width:           auto;
    border-collapse: collapse;
}
thead{
    background: #eee;
}
th{
    padding:     2px 5px;
    text-align:  center;
    border:      1px solid #999;
    color:       #3C578C;
    font-weight: bold;
}
tr{
    min-height: 20px;
}
td{
    border:  1px solid #999;
    padding: 4px 6px;
}
::selection{
    background: #d3dfee;
    color:      #000;
}

::-moz-selection{
    background: #d3dfee;
    color:      #000;
}

acronym, abbr{
    cursor: help;
}

label{
    cursor: pointer;
}

hr{
    height:           1px;
    color:            #bbb;
    background-color: #bbb;
    border:           none;
}

#content{
    width:      980px;
    margin:     0 auto;
    text-align: left;
    background: #fff;
}

    /* guide content */
div.image{
    -moz-border-radius:    7px;
    -webkit-border-radius: 7px;
    -khtml-border-radius:  7px;
    border-radius:         7px;
    margin:                10px 0;
    border:                3px solid #eee;
    text-align:            center;
}

div.image > p{
    background:  #eee;
    margin:      0;
    font-weight: bold;
    display:     block;
}

#content ul{
    list-style: disc inside;
}

#content ol{
    list-style: decimal inside;
}

#content li{
    line-height: 160%;
    text-align: left;
}

#content ul li ul{
    list-style-type: none;
    margin:          0 0 0 20px;

}

#content ul, #content ol{
    margin: 0 0 1em 2em;
    padding: 0;
   }

#content ul p, #content ol p{
    display: inline;
}

#content p{
    line-height:   170%;
    margin-bottom: 1em;
}

span.type{
    float:         left;
    font-size:     1em;
    padding-right: 0.5em;
    font-weight:   bold;
}

    /* code */
pre{
    display:       block;
    padding:       1em;
    background:    #fcfcfc;
    border-top:    1px solid #eee;
    border-bottom: 1px solid #eee;
    font-size:     10pt;
    font-family:   Consolas, "Courier New", Courier, monospace;
    margin:        1em 0;
    line-height:   130%;
}

code{
    border-bottom: 1px dotted #ccc;
    color:         #555;
    font-size:     10pt;
    font-family:   Consolas, "Courier New", Courier, monospace;
    line-height:   130%;
}

    /* --- code highlighting --- */

    /* html-code */
.html-hl-brackets,
.html-hl-reserved{
    color: #0000e6;
}

.html-hl-var,
.html-hl-quotes,
.html-hl-string{
    color: #009933;
}

.html-hl-code{
    color: #000020;
}

    /* php-code */
.php-hl-inlinetags{
    font-weight: bold;
}

.php-hl-comment{
    color: #777;
}

.php-hl-quotes,
.php-hl-string{
    color: #009933;
}

.php-hl-var{
    color: #6d3206;
}

.php-hl-reserved{
    color: #00e;
}

    /* css-code */
.css-hl-identifier{
    color: #007c00;
}

.css-hl-reserved{
    color: #0000e6;
}

    /* css-sql */
.sql-hl-reserved{
    color: #0000e6;
}

.sql-hl-identifier{
    color: #007c00;
}

.sql-hl-var{
    color: #0000e6;
}

.sql-hl-quotes, .sql-hl-string{
    color: #007c00;
}

    /*menu*/
#header{ background: #5D5D5D; display: none }
#header table{ margin: 10px 0 20px 0; }
#header, #header table, #header tbody, #header tr{ overflow: hidden; }
#header h3{
    font-size: 14px;
    color:     #fff;
    margin:    0;
    padding:   0;
}
#toogle-menu{
    background: #fff url(/images/nav_bg.jpg) repeat-x left top;
    padding:    0 240px 0 0;
    margin:     0;
    text-align: right;
}
    /*#header td:first-child{*/
    /*{*/
    /*background: none*/
    /*}*/
#header .sep{
    background: transparent url(/images/nav_separator.jpg) repeat-y left top;
}
#header td{
    vertical-align: top;
    border:         none !important;
    width:          25%;
    padding:        0 0 0 20px;
}
#header p{
    color:            #eee;
    background-color: transparent;
    padding:          0;
    margin:           0 0 10px 0;
}
#header ul{
    list-style-image: url(/images/arrow.gif);
    padding:          0 0 0 18px;
    margin:           8px 0 12px 0;
}
#header li{
    padding: 0;
    margin:  0 0 4px 0;
}

#header a{
    color:            #eee !important;
    background-color: transparent;
    text-decoration:  none;
    font-weight:      normal;
}

#header a:visited{
    color:            #eee !important;
    background-color: transparent;
    text-decoration:  none;
}

#header a:hover{
    color:            #ccc !important;
    text-decoration:  none;
    background-color: transparent;
}
#header .no-complete, #header .no-complete:hover{
    color: #999 !important;
}


</style>


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
    $introduction = array(
        'О главном'                  => '',
        'Требования к серверу'       => '',
        'Лог изменений'              => '',
        'Разработчики'               => '',
    );
    $conventions  = array(
        'Стандарты именования и кодирования'=> '/conventions/naming',
        'Структура директорий'              => '/conventions/directoryStructure',
        'Написание основных компонентов'    => '/conventions/mvc',
        'Совместная работа над проектом'    => '/conventions/cooperation',
    );
    $main_themes  = array(
        'Установка'         => '',
        'ActiveRecordModel' => '/mainThemes/activeRecordModel',
        'BaseController'    => '',
        'AdminController'   => '',
        'DbLogRoute'        => '',
        'GridView'          => '/mainThemes/gridView',
    );
    $modules      = array(
        'main'                           => '/main',
        'content - Контент'              => '/content',
        'products - Каталог продуктов'   => '/products',
        'orders - Заказы'                => '/orders',
        'fileManager - Файловый менеджер'=> '/fileManager',
        'rbac'                           => '/rbac',
        'faq'                            => '',
        'glossary'                       => '/glossary',
        'users'                          => '',
        'geo'                            => '',
        'mailer - Отправка почты'        => '',
    );
    ksort($modules);
    $helpers = array(
        'ImageHelper'      => '',
        'ArrayHelper'      => '',
        'FileSystem'       => '',
        'PasswordGenerator'=> '',
        'StringHelper'     => '',
    );
    ksort($helpers);
    $behaviors = array(
        'componentInModule' => '/behaviors/componentInModule',
        'metaTags'          => '/behaviors/metaTags',
    );
    ksort($behaviors);

    $app_components = array(
        'dater'      => '/applicationComponents/dater',
        'text'       => '/applicationComponents/text',
        'appManager' => '',
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
            echo CHtml::link($key, '/index.php' . $val, $data);
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
                    <?php show_menu('Введение', $introduction) ?>
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
                    <?php show_menu('Вспомогательные классы', $helpers) ?>
                    <?php show_menu('Специальные темы', $special) ?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div id="toogle-menu">
        <a href="#">
            <img src="/images/nav_toggle.jpg" width="153" height="44" border="0" title="Содержание" alt="Содержание">
        </a>
    </div>
    <div id="content">
        <?php echo $content ?>
    </div>
</div>
</body>
</html>
