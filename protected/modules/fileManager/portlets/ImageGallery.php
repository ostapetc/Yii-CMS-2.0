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
        'helpers'	=> array(
			'title'	=> array(
				'type' => 'outside'
			),
            'overlay'	=> array(
                'opacity' => 0.8,
                'css' => array(
                    'background-color' => '#000'
                    )
                ),
            'thumbs' => array(
                'width'	=> 50,
                'height' => 50
            ),
            'buttons' => array(),
            'media' => array(),
        )
    );

    public $carouselOptions = array();
    public $defalultCarouselOptions = array(
        'scroll' => 1
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
        $options = CJavaScript::encode(CMap::mergeArray($this->defaultFancyboxOptions, $this->fancyboxOptions));
        $carouselOptions = CJavaScript::encode(CMap::mergeArray($this->defalultCarouselOptions, $this->carouselOptions));
        $assets = $this->assets.'/imageGallery/';
        Yii::app()->clientScript
            ->registerScriptFile($assets.'fancybox/jquery.fancybox.pack.js')
            ->registerCssFile($assets.'fancybox/jquery.fancybox.css')
            ->registerScriptFile($assets.'fancybox/helpers/jquery.fancybox-buttons.js')
            ->registerCssFile($assets.'fancybox/helpers/jquery.fancybox-buttons.css')
            ->registerScriptFile($assets.'fancybox/helpers/jquery.fancybox-thumbs.js')
            ->registerCssFile($assets.'fancybox/helpers/jquery.fancybox-thumbs.css')
            ->registerScriptFile($assets.'fancybox/helpers/jquery.fancybox-media.js')
            ->registerScript($id, "$('#$id a').fancybox($options); ");
    }
}