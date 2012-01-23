<?php
Yii::import("zii.widgets.CListView");
class ListView extends CListView
{
    public $cssFile = '/css/yii/listview.css';
    public $pager = array(
        'class'   => 'LinkPager'
    );
    
}