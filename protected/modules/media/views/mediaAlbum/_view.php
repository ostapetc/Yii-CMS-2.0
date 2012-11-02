<?
$img = $data->getPreview(MediaAlbum::$image_size);
if ($img) {
?>
    <li id="File_<?=$data->id?>" class="gallery-item" style="width: <?= MediaAlbum::$image_size['width'] + 10 ?>px; height: <?= MediaAlbum::$image_size['height'] + 40 ?>px;">
        <?
        echo CHtml::link($img, $data->href, [
            "rel" => "album_photos",
            "title" => $data->title,
            "class" => "thumbnail",
            "data-object-id" => $data->id,
            "data-model-id" => get_class($data),
            "data-comments-url" => Yii::app()->createUrl('/comments/comment/list', array(
                'object_id' => $data->id,
                'model_id' => get_class($data)
            )),
        ]);
        ?>
    </li>
<? } ?>
