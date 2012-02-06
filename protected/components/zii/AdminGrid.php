<?php
class AdminGrid extends GridView
{
    public $pager = array('class'=> 'AdminLinkPager');

    //public $cssFile = '/css/admin/zii/gridView.css';

    public $itemsCssClass = 'tablesorter';

    public $template = '{items}<br/>{pager}';



    public function registerClientScript()
    {
        parent::registerClientScript();

        Yii::app()->clientScript->registerScript($this->getId().'CmsUI', "
            $('#{$this->getId()}').grid();
        ");
    }


    public function init()
    {
        $this->baseScriptUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.components.zii.assets')) . '/adminGrid';
        parent::init();
    }

}