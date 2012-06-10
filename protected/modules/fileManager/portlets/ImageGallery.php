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
        'autoSize' => false,
        'autoResize' => false,
        'mouseWheel' => false,
        'tpl' => array(
            'wrap' => '<div class="fancybox-wrap"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div> <div style="height: 100px"></div> </div>',
        ),
        'helpers'	=> array(
			'title'	=> array(
				'type' => 'over'
			),
            'overlay'	=> null,
            'vkstyle'	=> null,
            'media' => array(),
        ),
    );

    public $enablePagination = false;
    public $itemView ='fileManager.portlets.views.imageGalleryItem';
    public $itemsTagName = 'ul';


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

        $options = CJavaScript::encode(CMap::mergeArray($this->defaultFancyboxOptions, $this->fancyboxOptions));
        Yii::app()->clientScript
            ->registerScriptFile($assets.'fancybox/jquery.fancybox.js')
            ->registerCssFile($assets.'fancybox/jquery.fancybox.css')
            ->registerScriptFile($assets.'fancybox/helpers/jquery.fancybox-buttons.js')
            ->registerCssFile($assets.'fancybox/helpers/jquery.fancybox-buttons.css')
            ->registerScriptFile($assets.'fancybox/helpers/jquery.fancybox-thumbs.js')
            ->registerCssFile($assets.'fancybox/helpers/jquery.fancybox-thumbs.css')
            ->registerScriptFile($assets.'fancybox/helpers/jquery.fancybox-media.js')
            ->registerScriptFile($assets.'fancybox/helpers/jquery.fancybox-vkstyle.js')
            ->registerScript($id, "$('#$id a').fancybox($options); ");
    }

}