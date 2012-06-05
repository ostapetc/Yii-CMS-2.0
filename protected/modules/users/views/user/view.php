<div class="user_albums">
    <div>Альбомы</div>
    <?
    echo $form->toModalWindow('Создать новый альбом', array(
        'callback' => 'function ($form, data) {
            $.fn.yiiListView.update("albums");
        }'
    ));
    $this->widget('ListView', array(
        'id'=>'albums',
        'template' => "{pager}\n{items}\n{pager}",
        'dataProvider' => Yii::app()->getModule('fileManager')->getAlbumsDataProvider($model),
        'itemView' => '_album',
        'itemsTagName' => 'ul',
        'itemsCssClass' => 'thumbnails'
    ));
    ?>
</div>