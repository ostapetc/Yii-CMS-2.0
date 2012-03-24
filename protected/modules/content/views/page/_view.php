<?php
$url  = $this->createUrl($data->href);
$text = TextHelper::cut($data->text, 250, " ", "...");
?>
<div class="search_list">
    <h2><a href="<?php echo $url ?>" class="search_title"><?php echo $data->title; ?></a></h2>
    <p><?php echo $text; ?></p>
    <a href="<?php echo $url ?>" class="more_info"><?php t('Подробнее'); ?></a>
</div>



