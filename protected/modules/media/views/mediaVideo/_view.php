<?
$img = $data->getPreview(array('width' => 310, 'height' => 310));

if ($img) {
?>
    <li id="File_<?=$data->id?>" style="width: 321px;">
        <?
        echo CHtml::tag('span', array(
            "rel" => "album_photos",
            "title" => $data->title,
            "class" => "thumbnail",
            "data-object-id" => get_class($data),
            "data-model-id" => $data->id,
            "data-model-tag" => 'files',
        ), $img);
        ?>
    </li>
<? } ?>