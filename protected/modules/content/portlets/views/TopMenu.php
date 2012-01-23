<ul>
    <?php foreach ($sections as $section): ?>
    <?php
    $url   = $this->url($section->href);
    $class = $url == $_SERVER['REQUEST_URI'] ? 'active' : '';
    ?>
    <li class="<?php echo $class; ?>">
        <a href="<?php echo $url; ?>"><?php echo $section->title; ?></a>

        <?php
        if ($section->visibleChilds)
        {
            $this->render('_TopMenuSubmenu', array(
                'items' => $section->visible()->childs
            ));
        } ?>

    </li>
    <?php endforeach ?>
</ul>


