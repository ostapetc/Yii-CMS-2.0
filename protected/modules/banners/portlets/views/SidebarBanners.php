<div id="<?php echo $this->id ?>">
    <?php
    foreach ($banners as $banner)
    {
        $image = $banner->render(true);
        echo $banner->href ? CHtml::link($image, $banner->href) : $image;
    }
    ?>
</div>