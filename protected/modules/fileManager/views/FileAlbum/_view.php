<?
$size = array('width' => 134, 'height' => 125);
$img = ImageHelper::thumb($data->path, $data->name, $size, true);
if ($img) {
?>
    <li id="File_<?=$data->id?>" style="width: 134px; height: 120px;">
        <?
        echo CHtml::link($img, $data->href, array(
            "rel" => "album_photos",
            "title" => $data->title,
            "class" => "thumbnail",
            "data-object-id" => get_class($data),
            "data-model-id" => $data->id,
            "data-model-tag" => 'files',
        ));
        ?>
    </li>
<? } ?>