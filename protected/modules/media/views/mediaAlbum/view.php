<div class="user_photos">
    <?
    if ($model->isAttachedTo(Yii::app()->user->model))
    {
        $widget = $this->widget("media.portlets.Uploader", array(
            'model' => $model,
            'attribute' => 'files',
            'data_type' => 'image',
            'title' => 'Добавить фото',
            'uploadAction' => '/media/mediaFile/upload',
            'sortableAction' => '/media/mediaFile/savePriority',
            'existFilesAction' => '/media/mediaFile/existFiles'
        ));

        Yii::app()->clientScript->registerScript('close_'.$widget->getId(), "$('#{$widget->getId()}').on('hide',function(event) {
                $.fn.yiiListView.update('photos');
        });");
    }

    //Вынести action titles в провайдер, воспользоваться функцией CController
    $this->widget('media.portlets.ImageGallery', array(
        'id'=>'photos',
        'template' => "{pager}\n{items}\n{pager}",
        'dataProvider' => Yii::app()->getModule('media')->getFilesDataProvider($model, 'files', array('pagination' => false)),
        'itemView' => '_view',
        'itemsTagName' => 'ul',
        'itemsCssClass' => 'thumbnails',
        'sortableAction' => '/media/mediaFile/savePriority',
        'fancyboxOptions' => array(
            'helpers'=> array(
                'vkstyle' => array(
                    'additionalWidget' => 'comment_form'
                )
            )
        )

    ));
    ?>
    <div class="hide">
        <div id="comment_form">Комментарчики</div>
    </div>
</div>