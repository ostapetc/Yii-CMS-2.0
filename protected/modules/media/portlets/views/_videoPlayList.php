<?
/** @var $item YouTubeApi */
foreach ($data as $item) {
    echo CHtml::link($item->getPreview(['width' => 260, 'height' => 200]), ['/media/mediaVideo/view', 'id' => $item->id], [
        "class" => "thumbnail",
    ]);
    echo '<div class="clear"></div>';
    echo '<hr/>';
}