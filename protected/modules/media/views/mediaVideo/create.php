<div class="user_photos">
    <div class="btn-toolbar">
        <div class="btn-group">
            <a class="btn" href="<?= $this->createUrl('userAlbums', array('id' => $model->object_id)) ?>">
                <i class="icon-chevron-left"></i> Назад к Новостям
            </a>
            <?
            $widget = $this->widget('media.portlets.Uploader', array(
                //'as_modal'   => false,
                'name'          => 'uploader',
                'model'         => $model,
                'tag'           => 'videos',
                'data_type'     => 'video',
                'upload_action' => $this->createUrl('/media/mediaFile/upload')
            ));

            Yii::app()->clientScript->registerScript('close_' . $widget->getId(), "$('#{$widget->getId()}').on('hide',function(event) {
                $.fn.yiiListView.update('videos');
            });");
            ?>
        </div>
    </div>
    <?

    //Вынести action titles в провайдер, воспользоваться функцией CController
    $this->widget('media.portlets.ImageGallery', array(
        'id'              => 'videos',
        'dataProvider'    => $dp,
        'itemView'        => '_view',
        'itemsTagName'    => 'ul',
        'sortableEnable'  => $isOwner,
        'itemsCssClass'   => 'thumbnails',
        'fancyboxOptions' => array(
            'beforeShow'=> 'js:function() {
                //do some, comments for ex
            }'
        )
    ));
    ?>
</div>