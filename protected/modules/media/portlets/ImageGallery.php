<?php
Yii::import('media.portlets.BaseFileListView');
class ImageGallery extends BaseFileListView
{
    public $emptyText = '';
    public $template = "{items}{comments}";
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
            'overlay'	=> array(
                'closeClick' => true,
                'speedOut'   => 200,
                'showEarly'  => true,
                'css'        => array()
            ),
            'media' => array(),
            'vkstyle' => array()
        ),
    );

    public $itemView ='media.portlets.views.imageGalleryItem';
    public $itemsTagName = 'ul';
    public $enablePagination = false;

    public $sortableAction = '/media/mediaFileAdmin/savePriority';

    public $size = array(
        'width' => 100,
        'height' => 100
    );

    public function init()
    {
        $this->attachBehavior('sortable', array(
            'class' => 'application.components.zii.behaviors.SortableBehavior',
            'saveUrl'=>Yii::app()->createUrl($this->sortableAction)
        ));
        parent::init();
        $this->registerScripts();
    }

    public function registerScripts()
    {
        $id = $this->htmlOptions['id'];
        $assets = $this->assets.'/imageGallery/';
        $options = CJavaScript::encode(CMap::mergeArray($this->defaultFancyboxOptions, $this->fancyboxOptions));
        Yii::app()->clientScript
            ->registerScriptFile($assets.'fancybox/jquery.fancybox.js')
            ->registerCssFile($assets.'fancybox/jquery.fancybox.css')
            ->registerScriptFile($assets.'fancybox/helpers/jquery.fancybox-media.js')
            ->registerCssFile($assets.'fancybox/helpers/jquery.fancybox-vkstyle.css')
            ->registerScriptFile($assets.'fancybox/helpers/jquery.fancybox-vkstyle.js')
            ->registerScript($id, "$('#$id a').fancybox($options); ");
    }

}