<div class="user_photos">
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