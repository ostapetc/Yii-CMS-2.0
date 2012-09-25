<?
/** @var $item YouTubeApi */
foreach ($data as $item) {
    echo CHtml::tag('iframe', array(
        'src' => $item->player_url,
        'width' => '100%',
    ), true, true);
    echo '<div class="clear"></div>';
    echo '<hr/>';
}