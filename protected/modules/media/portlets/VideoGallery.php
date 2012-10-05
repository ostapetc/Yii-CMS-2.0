<?php
Yii::import('media.portlets.BaseFileListView');
class VideoGallery extends BaseFileListView
{
    public $emptyText = '';
    public $template = "{items}";

    public $itemView = 'media.portlets.views.videoGalleryItem';
    public $itemsTagName = 'div';
    public $enablePagination = false;

    public $sortableEnable = true;
    public $sortableOptions = array(
        'class'  => 'application.components.zii.behaviors.SortableBehavior',
        'saveUrl'=> '/media/mediaFileAdmin/savePriority'
    );

    public $size = array(
        'width'  => 112,
        'height' => 50
    );

    public $htmlOptions = array(
        'class' => 'video-gallery'
    );


    public function init()
    {
        if ($this->sortableEnable) {
            $this->attachBehavior('sortable', $this->sortableOptions);
        }
        parent::init();
        $this->registerScripts();
    }


    public function registerScripts()
    {
        $id             = $this->htmlOptions['id'];
        $assets         = $this->assets . '/imageGallery/';
        $options        = CJavaScript::encode(CMap::mergeArray($this->defaultFancyboxOptions, $this->fancyboxOptions));
    }

}