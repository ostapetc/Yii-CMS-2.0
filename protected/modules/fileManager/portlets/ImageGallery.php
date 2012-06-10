<?php
Yii::import('fileManager.portlets.BaseFileListView');
class ImageGallery extends BaseFileListView
{
    public $emptyText = '';
    public $template = "{items}";
    public $fancyboxOptions = array();
    public $defaultFancyboxOptions = array(
        'openEffect'  => 'fade',
        'closeEffect' => 'fade',
        'prevEffect' => 'fade',
        'nextEffect' => 'fade',
        'minWidth' => '800px',
        'autoCenter' => false,
        'mouseWheel' => false,
        'helpers'	=> array(
			'title'	=> array(
				'type' => 'over'
			),
            'overlay'	=> null,
            'media' => array(),
        ),
    );

    public $itemView ='fileManager.portlets.views.imageGalleryItem';
    public $itemsTagName = 'ul';
    public $enablePagination = false;

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
        $assets = $this->assets.'/imageGallery/';
        $this->attachBehavior('sortable', array(
            'class' => 'application.components.zii.behaviors.SortableBehavior',
            'saveUrl'=>Yii::app()->createUrl('/fileManager/fileManagerAdmin/savePriority')
        ));
        $options = CJavaScript::encode(CMap::mergeArray($this->defaultFancyboxOptions, $this->fancyboxOptions));
        Yii::app()->clientScript
            ->registerScriptFile($assets.'fancybox/jquery.fancybox.js')
            ->registerCssFile($assets.'fancybox/jquery.fancybox.css')
            ->registerScriptFile($assets.'fancybox/helpers/jquery.fancybox-buttons.js')
            ->registerCssFile($assets.'fancybox/helpers/jquery.fancybox-buttons.css')
            ->registerScriptFile($assets.'fancybox/helpers/jquery.fancybox-thumbs.js')
            ->registerCssFile($assets.'fancybox/helpers/jquery.fancybox-thumbs.css')
            ->registerScriptFile($assets.'fancybox/helpers/jquery.fancybox-media.js')
            ->registerCssFile($assets.'fancybox/helpers/jquery.fancybox-vkstyle.css')
            ->registerScriptFile($assets.'fancybox/helpers/jquery.fancybox-vkstyle.js')
            ->registerScript($id, "$('#$id a').fancybox($options); ");
    }

}