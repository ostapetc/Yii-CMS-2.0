<?php foreach ($modules as $module): ?>
    <?php
    if (!isset($module['admin_menu']) || !$module['admin_menu'])
    {
    	continue;
    }
    ?>

    <h3><?php echo $module['name']; ?></h3>
    <ul class="toggle">
        <?php foreach ($module['admin_menu'] as $title => $url): ?>
            <li class="icn_new_article">
                <a href="<?php echo $url; ?>"><?php echo $title; ?></a>
            </li>
        <?php endforeach ?>
    </ul>
<?php endforeach ?>

