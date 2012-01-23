<?php
Yii::import('zii.widgets.CBreadcrumbs');
class Breadcrumbs extends CBreadcrumbs
{
    public $homeLink = false;
    public $htmlOptions=array('class' => 'breadcrumbs');
    public $separator='<span> / </span>';
    public $currentPageClass = 'current';

    public function run()
    {
        if(empty($this->links))
            return;

        echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
        $this->_run();
        echo CHtml::closeTag($this->tagName);
    }

    private function _run()
    {
        $links=array();
        if($this->homeLink===null)
            $links[]=CHtml::link(Yii::t('zii','Home'),Yii::app()->homeUrl);
        else if($this->homeLink!==false)
            $links[]=$this->homeLink;
        foreach($this->links as $label=>$url)
        {
            if(is_string($label) || is_array($url))
                $links[]=CHtml::link($this->encodeLabel ? CHtml::encode($label) : $label, $url);
            else
                $links[]=CHtml::tag('span', array('class'=>$this->currentPageClass), $this->encodeLabel ? CHtml::encode($url) : $url);
        }
        echo implode($this->separator,$links);
    }

}

