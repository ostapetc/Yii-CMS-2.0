<div class="well sidebar-nav">
    <ul class="nav nav-list">
        <?php foreach ($sections as $section): ?>
            <?php if (Yii::app()->controller->isRootUrl($section->href)): ?>
                <li class="nav-header"><?php echo $section->title; ?></li>
            <?php else: ?>
                <?php $class = $section->isActive() ? "active" : ""; ?>
                <li class="<?php echo $class; ?>"><a href="<?php echo $section->href; ?>"><?php echo $section->title; ?></a></li>
            <?php endif ?>
        <?php endforeach ?>
    </ul>
</div>



