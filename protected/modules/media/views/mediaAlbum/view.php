<div class="user_photos">
    <div class="btn-toolbar">
        <div class="btn-group">
            <a class="btn" href="<?= $this->createUrl('manage', ['id' => $model->object_id]) ?>"><i class="icon-chevron-left"></i> Назад к Альбомам</a>
    <?
    $isOwner = $model->isAttachedTo(Yii::app()->user->model);
    if ($isOwner)
    {
        $widget = $this->widget("media.portlets.Uploader", [
            'model' => $model,
            'attribute' => 'files',
            'data_type' => 'image',
            'title' => 'Добавить фото',
            'upload_action' => '/media/mediaFile/upload',
            'sortable_action' => '/media/mediaFile/savePriority',
            'exist_files_action' => '/media/mediaFile/existFiles'
        ]);

        Yii::app()->clientScript->registerScript('close_'.$widget->getId(), "$('#modal_{$widget->getId()}').on('hide',function(event) {
            $.fn.yiiListView.update('photos');
        });");
    }
    ?>
        </div>
    </div>

    <?
    //Вынести action titles в провайдер, воспользоваться функцией CController
    $this->widget('media.portlets.ImageGallery', [
        'id'=>'photos',
        'dataProvider' => $dp,
        'itemView' => '_view',
        'itemsTagName' => 'ul',
        'sortableEnable' => $isOwner,
        'itemsCssClass' => 'thumbnails',
        'fancyboxOptions' => [
            'beforeShow'=> 'js:function() {
                //do some, comments for ex
            }'
        ]
    ]);
    ?>
</div>
