<a href="<?= $data->href ?>" data-fancybox-group="<?= 'imageGalleryGroup_' . $widget->getId() ?>" >
    <?= ImageHelper::thumb($data->path, $data->name, $widget->size, true)
    ->htmlOptions(array('class'=> "img-polaroid")); ?>
</a>
<?php
if ($index + 1 == $widget->dataProvider->getItemCount()) { ?>
    <div class="clear"></div>
<?php } ?>
