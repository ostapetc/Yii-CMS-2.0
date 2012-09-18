<div class="user_photos">
    <div class="btn-toolbar">
        <div class="btn-group">
            <a class="btn" href="<?= $this->createUrl('userAlbums', array('id' => $model->object_id)) ?>"><i class="icon-chevron-left"></i> Назад к Альбомам</a>
    <?
    $isOwner = $model->isAttachedTo(Yii::app()->user->model);
    if ($isOwner)
    {
        $widget = $this->widget("media.portlets.Uploader", array(
            'model' => $model,
            'attribute' => 'files',
            'data_type' => 'image',
            'title' => 'Добавить фото',
        ));

        Yii::app()->clientScript->registerScript('close_'.$widget->getId(), "$('#{$widget->getId()}').on('hide',function(event) {
                $.fn.yiiListView.update('photos');
        });");
    }
    ?>
        </div>
    </div>

    <?
    //Вынести action titles в провайдер, воспользоваться функцией CController
    $this->widget('media.portlets.ImageGallery', array(
        'id'=>'photos',
        'dataProvider' => $dp,
        'itemView' => '_view',
        'itemsTagName' => 'ul',
        'sortableEnable' => $isOwner,
        'itemsCssClass' => 'thumbnails',
        'fancyboxOptions' => array(
            'beforeShow'=> 'js:function() {
                //do some, comments for ex
            }'
        )
    ));
    ?>
</div>