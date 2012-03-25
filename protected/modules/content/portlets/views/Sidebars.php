<?php foreach ($sidebars as $sidebar): ?>
    <div class="well sidebar-nav" style="padding-left: 10px;padding-right: 10px">
        <?php echo $sidebar->html; ?>
    </div>
<?php endforeach ?>