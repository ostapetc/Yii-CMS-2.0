<?
$img = $data->getPreview(MediaAlbum::$image_size);
if ($img) {
?>
    <li id="File_<?=$data->id?>" style="width: <?= MediaAlbum::$image_size['width'] ?>px; ">
        <?
        echo CHtml::link($img, $data->href, [
            "rel" => "album_photos",
            "title" => $data->title,
            "class" => "thumbnail",
            "data-object-id" => get_class($data),
            "data-model-id" => $data->id,
            "data-model-tag" => 'files',
        ]);
        ?>
    </li>
<? } ?>