<div id="lang_div">
    <?php $max_index = count($langs) - 1; ?>

    <?php foreach ($langs as $i => $lang): ?>
        <?php if ($lang->id == Yii::app()->language): ?>
            <b><?php echo $lang->name; ?></b>
        <?php else: ?>
            <a href="/<?php echo $lang->id; ?>"><?php echo $lang->name; ?></a>
        <?php endif ?>

        <?php if ($max_index > $i): ?>
            &nbsp;|&nbsp;
        <?php endif ?>

    <?php endforeach ?>
</div>
