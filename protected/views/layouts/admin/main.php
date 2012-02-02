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
        <div class="btn_view_site"><a href="<?php echo $this->createUrl('/users/user/logout'); ?>">Выйти</a></div>
    </hgroup>
</header>
<!-- end of header bar -->

<section id="secondary_bar">
    <div class="user">
        <p><?php echo Yii::app()->user->model->full_name; ?></p>
        <!-- <a class="logout_user" href="#" title="Logout">Logout</a> -->
    </div>
    <div class="breadcrumbs_container">
        <article class="breadcrumbs"><a href="index.html">Website Admin</a>

            <div class="breadcrumb_divider"></div>
            <a class="current">Dashboard</a></article>
    </div>
</section>
<!-- end of secondary bar -->

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
<!-- end of sidebar -->

<section id="main" class="column">

<h4 class="alert_info">Welcome to the free MediaLoot admin panel template, this could be an informative message.</h4>

<?php $this->renderPartial('application.views.layouts.admin._chart'); ?>

    <?php $this->renderPartial('application.views.layouts.admin._grid'); ?>

<?php $this->renderPartial('application.views.layouts.admin._messages'); ?>

<!-- end of messages article -->

<div class="clear"></div>

<article class="module width_full">
    <header><h3>Post New Article</h3></header>
    <div class="module_content">
        <fieldset>
            <label>Post Title</label>
            <input type="text">
        </fieldset>
        <fieldset>
            <label>Content</label>
            <textarea rows="12"></textarea>
        </fieldset>
        <fieldset style="width:48%; float:left; margin-right: 3%;"> <!-- to make two field float next to one another, adjust values accordingly -->
            <label>Category</label>
            <select style="width:92%;">
                <option>Articles</option>
                <option>Tutorials</option>
                <option>Freebies</option>
            </select>
        </fieldset>
        <fieldset style="width:48%; float:left;"> <!-- to make two field float next to one another, adjust values accordingly -->
            <label>Tags</label>
            <input type="text" style="width:92%;">
        </fieldset>
        <div class="clear"></div>
    </div>
    <footer>
        <div class="submit_link">
            <select>
                <option>Draft</option>
                <option>Published</option>
            </select>
            <input type="submit" value="Publish" class="alt_btn">
            <input type="submit" value="Reset">
        </div>
    </footer>
</article>
<!-- end of post new article -->

<h4 class="alert_warning">A Warning Alert</h4>

<h4 class="alert_error">An Error Message</h4>

<h4 class="alert_success">A Success Message</h4>

<article class="module width_full">
    <header><h3>Basic Styles</h3></header>
    <div class="module_content">
        <h1>Header 1</h1>

        <h2>Header 2</h2>

        <h3>Header 3</h3>
        <h4>Header 4</h4>

        <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras mattis consectetur purus sit amet fermentum. Maecenas faucibus mollis
            interdum. Maecenas faucibus mollis interdum. Cras justo odio, dapibus ac facilisis in, egestas eget quam.</p>

        <p>Donec id elit non mi porta <a href="#">link text</a> gravida at eget metus. Donec ullamcorper nulla non metus auctor fringilla. Cras mattis consectetur purus sit amet
            fermentum. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.</p>

        <ul>
            <li>Donec ullamcorper nulla non metus auctor fringilla.</li>
            <li>Cras mattis consectetur purus sit amet fermentum.</li>
            <li>Donec ullamcorper nulla non metus auctor fringilla.</li>
            <li>Cras mattis consectetur purus sit amet fermentum.</li>
        </ul>
    </div>
</article>
<!-- end of styles article -->
<div class="spacer"></div>
</section>


</body>

</html>