<?php
class MultilangApListView extends ApListView
{
    public $template="{alphapager}\n{items}\n{pager}";
    public $alphaPager=array('class'=>'MultilangApLinkPager');

}