<?
$img = $data->getPreview(['width' => 320, 'height' => 260]);

if ($img) {
?>
    <li id="File_<?=$data->id?>" style="width: 331px;">
        <?
        echo CHtml::tag('span', [
            "rel" => "album_photos",
            "title" => $data->title,
            "class" => "thumbnail",
            "data-object-id" => get_class($data),
            "data-model-id" => $data->id,
            "data-model-tag" => 'files',
        ], $img);
        ?>
    </li>
<? } ?>