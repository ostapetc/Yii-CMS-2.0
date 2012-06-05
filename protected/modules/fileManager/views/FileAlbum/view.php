<div class="user_photos">
    <div>Альбомы</div>
    <?
    $widget = $this->widget("fileManager.portlets.Uploader", array(
        'model' => $model,
        'attribute' => 'files',
        'data_type' => 'image',
        'title' => 'Добавить фото'
    ));
    Yii::app()->clientScript->registerScript('close_'.$widget->getId(), "$('#{$widget->getId()}').bind('dialogclose',function(event) {
            $.fn.yiiListView.update('photos');
    });");
    $this->widget('fileManager.portlets.ImageGallery', array(
        'id'=>'photos',
        'template' => "{pager}\n{items}\n{pager}",
        'dataProvider' => Yii::app()->getModule('fileManager')->getFilesDataProvider($model, 'files', array('pagination' => false)),
        'itemView' => '_view',
        'itemsTagName' => 'ul',
        'itemsCssClass' => 'thumbnails'
    ));
    ?>
</div>