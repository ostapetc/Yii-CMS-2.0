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


    $cs->registerScriptFile('/js/plugins/blockUI/blockUI.js');
    $cs->registerScriptFile('/js/plugins/blockUI/loaders.js');
    $cs->registerScriptFile('/js/plugins/jgrowl/jquery.jgrowl.js');
    $cs->registerCssFile('/js/plugins/jgrowl/jquery.jgrowl.css');

    ?>

    <!--[if lt IE 9]>
    <link rel="stylesheet" href="/css/admin/ie.css" type="text/css" media="screen"/>
    <script src="/js/admin/html5.js"></script>
    <![endif]-->
</head>


<body>

<header id="header">
    <hgroup>
        <h1 class="site_title"><a href="index.html">Website Admin</a></h1>

        <h2 class="section_title">Dashboard</h2>

        <div class="btn_view_site"><a href="http://www.medialoot.com">View Site</a></div>
    </hgroup>
</header>
<!-- end of header bar -->

<section id="secondary_bar">
    <div class="user">
        <p>John Doe (<a href="#">3 Messages</a>)</p>
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
    <form class="quick_search">
        <input type="text" value="Quick Search" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;">
    </form>
    <hr/>
    <h3>Content</h3>
    <ul class="toggle">
        <li class="icn_new_article"><a href="#">New Article</a></li>
        <li class="icn_edit_article"><a href="#">Edit Articles</a></li>
        <li class="icn_categories"><a href="#">Categories</a></li>
        <li class="icn_tags"><a href="#">Tags</a></li>
    </ul>
    <h3>Users</h3>
    <ul class="toggle">
        <li class="icn_add_user"><a href="#">Add New User</a></li>
        <li class="icn_view_users"><a href="#">View Users</a></li>
        <li class="icn_profile"><a href="#">Your Profile</a></li>
    </ul>
    <h3>Media</h3>
    <ul class="toggle">
        <li class="icn_folder"><a href="#">File Manager</a></li>
        <li class="icn_photo"><a href="#">Gallery</a></li>
        <li class="icn_audio"><a href="#">Audio</a></li>
        <li class="icn_video"><a href="#">Video</a></li>
    </ul>
    <h3>Admin</h3>
    <ul class="toggle">
        <li class="icn_settings"><a href="#">Options</a></li>
        <li class="icn_security"><a href="#">Security</a></li>
        <li class="icn_jump_back"><a href="#">Logout</a></li>
    </ul>

    <footer>
        <hr/>
        <p><strong>Copyright &copy; 2011 Website Admin</strong></p>

        <p>Theme by <a href="http://www.medialoot.com">MediaLoot</a></p>
    </footer>
</aside>
<!-- end of sidebar -->

<section id="main" class="column">

<h4 class="alert_info">Welcome to the free MediaLoot admin panel template, this could be an informative message.</h4>

<article class="module width_full">
    <header><h3>Stats</h3></header>
    <div class="module_content">
        <article class="stats_graph">
            <img src="http://chart.apis.google.com/chart?chxr=0,0,3000&chxt=y&chs=520x140&cht=lc&chco=76A4FB,80C65A&chd=s:Tdjpsvyvttmiihgmnrst,OTbdcfhhggcTUTTUadfk&chls=2|2&chma=40,20,20,30"
                 width="520" height="140" alt=""/>
        </article>

        <article class="stats_overview">
            <div class="overview_today">
                <p class="overview_day">Today</p>

                <p class="overview_count">1,876</p>

                <p class="overview_type">Hits</p>

                <p class="overview_count">2,103</p>

                <p class="overview_type">Views</p>
            </div>
            <div class="overview_previous">
                <p class="overview_day">Yesterday</p>

                <p class="overview_count">1,646</p>

                <p class="overview_type">Hits</p>

                <p class="overview_count">2,054</p>

                <p class="overview_type">Views</p>
            </div>
        </article>
        <div class="clear"></div>
    </div>
</article>
<!-- end of stats article -->

<article class="module width_3_quarter">
    <header><h3 class="tabs_involved">Content Manager</h3>
        <ul class="tabs">
            <li><a href="#tab1">Posts</a></li>
            <li><a href="#tab2">Comments</a></li>
        </ul>
    </header>

    <div class="tab_container">
        <div id="tab1" class="tab_content">
            <table class="tablesorter" cellspacing="0">
                <thead>
                <tr>
                    <th></th>
                    <th>Entry Name</th>
                    <th>Category</th>
                    <th>Created On</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>Lorem Ipsum Dolor Sit Amet</td>
                    <td>Articles</td>
                    <td>5th April 2011</td>
                    <td><input type="image" src="/images/admin/icn_edit.png" title="Edit"><input type="image" src="/images/admin/icn_trash.png" title="Trash"></td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>Ipsum Lorem Dolor Sit Amet</td>
                    <td>Freebies</td>
                    <td>6th April 2011</td>
                    <td><input type="image" src="/images/admin/icn_edit.png" title="Edit"><input type="image" src="/images/admin/icn_trash.png" title="Trash"></td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>Sit Amet Dolor Ipsum</td>
                    <td>Tutorials</td>
                    <td>10th April 2011</td>
                    <td><input type="image" src="/images/admin/icn_edit.png" title="Edit"><input type="image" src="/images/admin/icn_trash.png" title="Trash"></td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>Dolor Lorem Amet</td>
                    <td>Articles</td>
                    <td>16th April 2011</td>
                    <td><input type="image" src="/images/admin/icn_edit.png" title="Edit"><input type="image" src="/images/admin/icn_trash.png" title="Trash"></td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>Dolor Lorem Amet</td>
                    <td>Articles</td>
                    <td>16th April 2011</td>
                    <td><input type="image" src="/images/admin/icn_edit.png" title="Edit"><input type="image" src="/images/admin/icn_trash.png" title="Trash"></td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- end of #tab1 -->

        <div id="tab2" class="tab_content">
            <table class="tablesorter" cellspacing="0">
                <thead>
                <tr>
                    <th></th>
                    <th>Comment</th>
                    <th>Posted by</th>
                    <th>Posted On</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>Lorem Ipsum Dolor Sit Amet</td>
                    <td>Mark Corrigan</td>
                    <td>5th April 2011</td>
                    <td><input type="image" src="/images/admin/icn_edit.png" title="Edit"><input type="image" src="/images/admin/icn_trash.png" title="Trash"></td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>Ipsum Lorem Dolor Sit Amet</td>
                    <td>Jeremy Usbourne</td>
                    <td>6th April 2011</td>
                    <td><input type="image" src="/images/admin/icn_edit.png" title="Edit"><input type="image" src="/images/admin/icn_trash.png" title="Trash"></td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>Sit Amet Dolor Ipsum</td>
                    <td>Super Hans</td>
                    <td>10th April 2011</td>
                    <td><input type="image" src="/images/admin/icn_edit.png" title="Edit"><input type="image" src="/images/admin/icn_trash.png" title="Trash"></td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>Dolor Lorem Amet</td>
                    <td>Alan Johnson</td>
                    <td>16th April 2011</td>
                    <td><input type="image" src="/images/admin/icn_edit.png" title="Edit"><input type="image" src="/images/admin/icn_trash.png" title="Trash"></td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>Dolor Lorem Amet</td>
                    <td>Dobby</td>
                    <td>16th April 2011</td>
                    <td><input type="image" src="/images/admin/icn_edit.png" title="Edit"><input type="image" src="/images/admin/icn_trash.png" title="Trash"></td>
                </tr>
                </tbody>
            </table>

        </div>
        <!-- end of #tab2 -->

    </div>
    <!-- end of .tab_container -->

</article>
<!-- end of content manager article -->

<article class="module width_quarter">
    <header><h3>Messages</h3></header>
    <div class="message_list">
        <div class="module_content">
            <div class="message"><p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor.</p>

                <p><strong>John Doe</strong></p></div>
            <div class="message"><p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor.</p>

                <p><strong>John Doe</strong></p></div>
            <div class="message"><p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor.</p>

                <p><strong>John Doe</strong></p></div>
            <div class="message"><p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor.</p>

                <p><strong>John Doe</strong></p></div>
            <div class="message"><p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor.</p>

                <p><strong>John Doe</strong></p></div>
        </div>
    </div>
    <footer>
        <form class="post_message">
            <input type="text" value="Message" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;">
            <input type="submit" class="btn_post_message" value=""/>
        </form>
    </footer>
</article>
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