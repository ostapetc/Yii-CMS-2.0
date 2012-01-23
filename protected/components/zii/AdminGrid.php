<?php
class AdminGrid extends GridView
{
    public $pager = array('class'=> 'AdminLinkPager');
    public $cssFile = "/css/admin/gridview/styles.css";

    public function registerClientScript()
    {
        parent::registerClientScript();

        Yii::app()->clientScript->registerScript($this->getId().'CmsUI', "
            $('#{$this->getId()}').grid();
        ");
    }
}