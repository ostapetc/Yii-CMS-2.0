<?php foreach ($banners as $banner): ?>
    <div class="text">
        <?php if ($banner->href): ?>
            <a href="<?php echo $banner->href; ?>" title="<?php echo $banner->name; ?>">
        <?php endif ?>

        <?php $banner->render(); ?>

        <?php if ($banner->url): ?>
            </a>
        <?php endif ?>
    </div>
<?php endforeach ?>

