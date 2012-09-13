<?php
Yii::import('media.portlets.BaseFileListView');
class ImageGallery extends BaseFileListView
{
    public $emptyText = '';
    public $template = "{items}<div class='clear'></div> ";
    public $fancyboxOptions = array();
    public $defaultFancyboxOptions = array(
        'openEffect'  => 'fade',
        'closeEffect' => 'fade',
        'closeSpeed'  => 0,
        'prevEffect'  => 'fade',
        'nextEffect'  => 'fade',
        'minWidth'    => '800px',
        'autoCenter'  => false,
        'mouseWheel'  => false,
        'helpers'     => array(
            'title'      => array(
                'type' => 'over'
            ),
            'overlay'    => array(
                'closeClick' => true,
                'speedOut'   => 200,
                'showEarly'  => true
            ),
            'media'      => array(),
            'vkstyle'    => array()
        ),
    );

    public $montageOptions = array();
    public $defaultMontageOptions = array(
        'margin' => 5,
//        'minsize'	=> true,
//        'liquid' => true,
        'fixedHeight' => 130,
//        'fillLastRow'          => true,
        'minw' => 70,
        'minh' => 90,
        'maxh' => 150,	// the maximum height that a picture should have.
//        'alternateHeight'      => true,
//        'alternateHeightRange' => array(
//            'min'    => 90,
//            'max'    => 150
//        ),
    );
    public $itemView = 'media.portlets.views.imageGalleryItem';
    public $itemsTagName = 'div';
    public $enablePagination = false;

    public $sortableAction = '/media/mediaFileAdmin/savePriority';

    public $size = array(
        'width'  => null,
        'height' => 130
    );

    public $htmlOptions = array(
        'class' => 'image-gallery'
    );


    public function init()
    {
        $this->attachBehavior('sortable', array(
            'class'  => 'application.components.zii.behaviors.SortableBehavior',
            'saveUrl'=> Yii::app()->createUrl($this->sortableAction)
        ));
        parent::init();
        $this->registerScripts();
    }


    public function registerScripts()
    {
        $id             = $this->htmlOptions['id'];
        $assets         = $this->assets . '/imageGallery/';
        $options        = CJavaScript::encode(CMap::mergeArray($this->defaultFancyboxOptions,
            $this->fancyboxOptions));
        $montageOptions = CJavaScript::encode(CMap::mergeArray($this->defaultMontageOptions,
            $this->montageOptions));
        Yii::app()->clientScript->registerCssFile($assets . 'imageGallery.css')->registerScriptFile(
            $assets . 'fancybox/jquery.fancybox.js')->registerCssFile(
            $assets . 'fancybox/jquery.fancybox.css')->registerScriptFile(
            $assets . 'fancybox/helpers/jquery.fancybox-media.js')->registerCssFile(
            $assets . 'fancybox/helpers/jquery.fancybox-vkstyle.css')->registerScriptFile(
            $assets . 'fancybox/helpers/jquery.fancybox-vkstyle.js')->registerCssFile(
            $assets . 'montage/css/style.css')->registerScriptFile($assets . 'montage/js/jquery.montage.js')
            ->registerScript($id, <<<JS
                $('#$id a').fancybox($options);

                var container 	= $('#$id'),
                    imgs		= container.find('img').hide(),
                    totalImgs	= imgs.length,
                    cnt			= 0;

                    imgs.each(function(i) {
                        var img	= $(this);
                        $('<img/>').load(function() {
                            ++cnt;
                            if( cnt === totalImgs ) {
                                imgs.show();
                                container.find('.items').montage({$montageOptions})

                                /*
                                 * just for this demo:
                                 */
                                $('#overlay').fadeIn(500);
                            }
                        }).attr('src',img.attr('src'));
                    });
JS
);
    }

}