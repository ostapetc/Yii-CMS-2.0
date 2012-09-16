<?
$img = ImageHelper::thumb($data->path, $data->name, MediaAlbum::$image_size, true);
if ($img) {
?>
    <li id="File_<?=$data->id?>" style="width: <?= MediaAlbum::$image_size['width'] ?>px;">
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