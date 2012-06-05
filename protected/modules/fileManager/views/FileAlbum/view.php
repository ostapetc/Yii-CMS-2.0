<div class="user_photos">
    <div>Альбомы</div>
    <?
    echo $form->toModalWindow('Добавить фото', array(
        'callback' => 'function ($form, data) {
            $.fn.yiiListView.update("photos");
        }'
    ));
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