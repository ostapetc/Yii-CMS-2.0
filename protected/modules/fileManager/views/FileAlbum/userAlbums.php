<div class="user_albums">
    <?
    echo $form->toModalWindow('Создать новый альбом', array(
        'callback' => 'function ($form, data) {
            $.fn.yiiListView.update("albums");
        }'
    ));
    $this->widget('ListView', array(
        'id'=>'albums',
        'template' => "{pager}\n{items}\n{pager}",
        'dataProvider' => Yii::app()->getModule('fileManager')->getAlbumsDataProvider($user, array(
            'criteria' => array(
                'order' => 'date_create DESC'
            )
        )),
        'itemView' => '_album',
        'itemsTagName' => 'ul',
        'itemsCssClass' => 'thumbnails'
    ));
    ?>
</div>