<?
/** @var $item YouTubeApi */
foreach ($data as $item) {
    echo $item->getPreview(['width' => 260, 'height' => 200]);
    echo '<div class="clear"></div>';
    echo '<hr/>';
}