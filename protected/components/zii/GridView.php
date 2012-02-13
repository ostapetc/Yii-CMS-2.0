<?php
class GridView extends BootGridView
{
    public $pager = array('class'=> 'LinkPager');
    public $template = '{items}<br/>{pager}';

}