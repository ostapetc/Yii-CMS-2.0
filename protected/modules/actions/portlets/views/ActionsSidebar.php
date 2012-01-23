<div class="green_line"><?php echo Yii::t('ActionsModule.main', 'БЛИЖАЙШИЕ МЕРОПРИЯТИЯ'); ?></div>

<?php $class = ' even'; ?>

<?php foreach ($actions as $action): ?>
    <?php
    $class = $class == 'even' ?  'odd' : 'even';

    $title_len = 48;
    
    if (mb_strlen($action->name, "utf-8") > $title_len) 
    {
        $action->name = mb_substr($action->name, 0, 48, 'utf-8') . "...";
    }

    $url = $this->url("/action/{$action->id}");
    ?>

    <div class="events <?php echo $class ?>">

        <a href="<?php echo $url; ?>">
            <?php echo ImageHelper::thumb(Action::IMG_DIR, $action->image, Action::IMG_SMALL_WIDTH, Action::IMG_SMALL_HEIGHT, true); ?>
        </a>

        <div class="event_date">
            <?php echo Yii::app()->dateFormatter->format('dd MMMM yyyy', $action->date); ?>
        </div>

        <a href="<?php echo $url; ?>" class="event_title">
            <?php echo $action->name; ?>
        </a>
    </div>
<?php endforeach ?>


