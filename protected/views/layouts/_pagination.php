<div style="text-align:center;margin:30px 0 10px 0">
    <?php
    $this->widget(
        'CLinkPager',
        array(
            'pages'   => $pages,
            'cssFile' => '/css/yii/pager.css',
            'header'  => '',
            'footer'  => '',
            'firstPageLabel' => '',
            'lastPageLabel'  => '',
            'nextPageLabel'  => '',
            'prevPageLabel'  => '',
    ));
    ?>
</div>