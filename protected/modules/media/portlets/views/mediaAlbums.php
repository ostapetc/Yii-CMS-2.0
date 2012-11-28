<h4><?= $this->title ?></h4>
<div class="user_albums">
    <?
    if ($this->is_my)
    {
        echo CHtml::link('<i class="icon-plus-sign"></i> '.t('Создать новый альбом'), ['/media/mediaAlbum/createUsers'], [
            'class'      => 'modal-link btn',
            'data-title' => 'Создание нового фото-альбома'
        ]);
    }

    $this->widget('ListView', [
        'id'=>'user_albums',
        'template' => "{pager}\n{items}\n{pager}",
        'dataProvider' => $dp,
        'itemView' => '_mediaAlbums',
        'itemsTagName' => 'ul',
        'itemsCssClass' => 'thumbnails',
        'htmlOptions' => [
            'class' => 'image-gallery'
        ]
    ]);
    ?>
</div>