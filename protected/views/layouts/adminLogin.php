<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title></title>

    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

    <style type="text/css" media="all">
        @import url("/css/admin/style.css");
        @import url("/css/admin/jquery.wysiwyg.css");
        @import url("/css/admin/facebox.css");
        @import url("/css/admin/visualize.css");
        @import url("/css/admin/date_input.css");
        @import url("/css/admin/messages.css");
        @import url("/css/admin/forms.css");
    </style>

    <!--[if lt IE 8]>
    <style type="text/css" media="all">@import url("/css/admin/ie.css");</style>
    <![endif]-->

</head>
<body>

<div id="hld">

    <div class="wrapper">        <!-- wrapper begins -->

        <div class="block small center login">

            <div class="block_head">
                <div class="bheadl"></div>
                <div class="bheadr"></div>

                <h2>Вход в админ панель</h2>
                <ul>
                    <li class="nobg"><a href="/">Вернуться на сайт</a></li>
                </ul>
            </div>
            <!-- .block_head ends -->

            <div class="block_content">
                <?php echo $content ?>
            </div>
            <!-- .block_content ends -->

            <div class="bendl"></div>
            <div class="bendr"></div>

        </div>
        <!-- .login ends -->

    </div>
    <!-- wrapper ends -->

</div>
<!-- #hld ends -->


<!--[if IE]>
<script type="text/javascript" src="/js/admin/excanvas.js"></script><![endif]-->
<script type="text/javascript" src="/js/admin/facebox.js"></script>
<script type="text/javascript" src="/js/admin/jquery.js"></script>
<script type="text/javascript" src="/js/admin/ajaxupload.js"></script>
<script type="text/javascript" src="/js/admin/custom.js"></script>


<div id="facebox" style="display: none;">
    <div class="popup">
        <table>
            <tbody>
            <tr>
                <td class="tl"></td>
                <td class="b"></td>
                <td class="tr"></td>
            </tr>
            <tr>
                <td class="b"></td>
                <td class="body">
                    <div class="content"></div>
                    <div class="footer"><a href="#" class="close"> <img src="/images/admin/closelabel.gif" title="close" class="close_image"> </a></div>
                </td>
                <td class="b"></td>
            </tr>
            <tr>
                <td class="bl"></td>
                <td class="b"></td>
                <td class="br"></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
