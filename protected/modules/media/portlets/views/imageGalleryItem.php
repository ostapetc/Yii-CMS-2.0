<a href="<?= $data->href ?>" data-fancybox-group="<?= 'imageGalleryGroup_' . $widget->getId() ?>">
<!--    --><?php //$widget->size['width'] = rand(70, 110); ?>
    <?= ImageHelper::thumb($data->path, $data->name, $widget->size, false)
    ->htmlOptions(array('class'=> "")); ?>
</a>
<?php
if ($index + 1 == $widget->dataProvider->getItemCount()) { ?>
    <div class="clear"></div>
<?php } ?>
