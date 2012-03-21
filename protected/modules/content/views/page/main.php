<?php if ($page): ?>
    <?php $this->left_menu_id = $page->left_menu_id; ?>
    <div class="hero-unit">
        <?php echo $page->text; ?>
    </div>
<?php endif ?>

<?php
$pages_collections  = array_chunk($pages, 3);
?>

<?php foreach ($pages_collections as $pages): ?>
    <div class = "row-fluid">
        <?php foreach ($pages as $page): ?>
            <div class="span4">
                <h2><?php echo $page->title; ?></h2>

                <?php echo $page->short_text; ?>

                <p><a class="btn" href="<?php echo $page->href; ?>">Далее &raquo;</a></p>
            </div>
        <?php endforeach ?>
    </div>
<?php endforeach ?>
