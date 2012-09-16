<div class="user_albums">
    <?
    if ($is_my)
    {
        echo CHtml::link(t('Создать новый альбом'), array('/media/mediaAlbum/createUsers'), array(
            'class'      => 'modal-link',
            'data-title' => 'Создание нового фото-альбома'
        ));
    }
    $this->widget('ListView', array(
        'id'=>'user_albums',
        'template' => "{pager}\n{items}\n{pager}",
        'dataProvider' => Yii::app()->getModule('media')->getAlbumsDataProvider($user, array(
            'criteria' => array(
                'order' => 'date_create DESC'
            )
        )),
        'itemView' => '_album',
        'itemsTagName' => 'ul',
        'itemsCssClass' => 'thumbnails',
        'htmlOptions' => array(
            'class' => 'image-gallery'
        )
    ));
    ?>
</div>