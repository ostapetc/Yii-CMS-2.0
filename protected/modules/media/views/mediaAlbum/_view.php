<?
$img = $data->getPreview(MediaAlbum::$image_size);
if ($img) {
?>
    <li id="File_<?=$data->id?>" class="gallery-item <?= $index % 4 == 0 ? 'clear' : '' ?>" style="width: <?= MediaAlbum::$image_size['width'] + 10 ?>px;">
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
