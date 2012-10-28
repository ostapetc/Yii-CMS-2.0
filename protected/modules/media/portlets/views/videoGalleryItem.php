<a href="<?= $data->href ?>" data-fancybox-group="<?= 'imageGalleryGroup_' . $widget->getId() ?>" >
    <?
    $src = ImageHelper::thumbSrc($data->path, $data->name, $widget->size, true);
    echo CHtml::image($src, '', ['class'=> "img-polaroid"]);
    ?>
</a>
