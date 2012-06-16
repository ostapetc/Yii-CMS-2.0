<div class="user_photos">
    <?
    $widget = $this->widget("fileManager.portlets.Uploader", array(
        'model' => $model,
        'attribute' => 'files',
        'data_type' => 'image',
        'title' => 'Добавить фото',
        'uploadAction' => '/fileManager/fileManager/upload',
        'sortableAction' => '/fileManager/fileManager/savePriority',
        'existFilesAction' => '/fileManager/fileManager/existFiles'
    ));
    Yii::app()->clientScript->registerScript('close_'.$widget->getId(), "$('#{$widget->getId()}').on('hide',function(event) {
            $.fn.yiiListView.update('photos', function() {alert(3)});
    });");
    ?>
    <br />
    <br />
    <?

    //Вынести action titles в провайдер, воспользоваться функцией CController
    $this->widget('fileManager.portlets.ImageGallery', array(
        'id'=>'photos',
        'template' => "{pager}\n{items}\n{pager}",
        'dataProvider' => Yii::app()->getModule('fileManager')->getFilesDataProvider($model, 'files', array('pagination' => false)),
        'itemView' => '_view',
        'itemsTagName' => 'ul',
        'itemsCssClass' => 'thumbnails',
        'sortableAction' => '/fileManager/fileManager/savePriority',
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