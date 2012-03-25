<?
$url  = $this->createUrl($data->href);
$text = TextHelper::cut($data->text, 250, " ", "...");
?>
<div class="search_list">
    <h2><a href="<? echo $url ?>" class="search_title"><? echo $data->title; ?></a></h2>
    <p><? echo $text; ?></p>
    <a href="<? echo $url ?>" class="more_info"><? t('Подробнее'); ?></a>
</div>



