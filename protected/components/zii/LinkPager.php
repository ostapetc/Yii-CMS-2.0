<?php

class LinkPager extends CLinkPager
{
    public $cssFile = '/css/yii/pager.css';

    public $lastPageLabel = '';
    public $firstPageLabel = '';
    public $prevPageLabel = '';
    public $nextPageLabel = '';

    public $header = '';

    public $htmlOptions = array(
        'id' => 'page_nav'
    );
    
    protected function createPageButton($label, $page, $class, $hidden, $selected)
    {
        if ($hidden)
        {
            if ($hidden)
            {
                $class .= ' '.self::CSS_HIDDEN_PAGE;
            }
            else
            {
                $class .= ' '.self::CSS_SELECTED_PAGE;
                $label = '['.$label.']';
            }
        }
        if ($selected)
        {
            return CHtml::tag('span', array(), $label);
        }
        return CHtml::link($label, $this->createPageUrl($page));
    }

}