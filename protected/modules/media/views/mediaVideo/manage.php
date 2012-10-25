<div class="video-manage">
    <div class="btn-toolbar">
        <div class="btn-group">
            <?
            if ($is_my) {
                $widget = $this->widget('media.portlets.Uploader', [
                    //'as_modal'   => false,
                    'name'          => 'uploader',
                    'model'         => $model,
                    'tag'           => 'videos',
                    'data_type'     => 'video',
                    'upload_action' => '/media/mediaFile/upload',
                    'link_parser_action' => 'media/mediaFile/linkParser'
                ]);

                Yii::app()->clientScript->registerScript('close_' . $widget->getId(), "$('#{$widget->getId()}').on('hide',function(event) {
                    $.fn.yiiListView.update('videos');
                });");
            }
            ?>
        </div>
    </div>
    <?

    //Вынести action titles в провайдер, воспользоваться функцией CController
    $this->widget('media.portlets.ImageGallery', [
        'id'              => 'videos',
        'dataProvider'    => $dp,
        'itemView'        => '_galleryItem',
        'itemsTagName'    => 'ul',
//        'sortableEnable'  => $isOwner,
        'itemsCssClass'   => 'thumbnails',
        'fancyboxOptions' => [
            'beforeShow'=> 'js:function() {
                //do some, comments for ex
            }'
        ]
    ]);
    ?>
</div>