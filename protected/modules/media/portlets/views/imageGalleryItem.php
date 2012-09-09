<li>
    <a href="<?= $data->href ?>" data-fancybox-group="<?= 'imageGalleryGroup_'.$widget->getId() ?>" >
        <?= ImageHelper::thumb($data->path, $data->name, $widget->size, true); ?>
    </a>
</li>
