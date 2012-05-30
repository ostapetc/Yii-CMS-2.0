<?php
Yii::import('fileManager.portlets.BaseFileListView');
class FancyGallery extends BaseFileListView
{
    public $template = "{items}";
    public $fancyboxOptions = array();
    public $itemView ='fileManager.portlets.views.fancyGalleryItem';

    public $size = array(
        'width' => 100,
        'height' => 100
    );

    public function init()
    {
        parent::init();
        $this->registerScripts();
    }

    public function registerScripts()
    {
        $id = $this->htmlOptions['id'];
        $options = CJavaScript::encode($this->fancyboxOptions);

        Yii::app()->clientScript
            ->registerScriptFile($this->assets.'/fancyboxGallery/jquery.fancybox.js')
            ->registerCssFile($this->assets.'/fancyboxGallery/jquery.fancybox.css')
            ->registerScript($id, "$('#$id a').fancybox($options)");
    }
}