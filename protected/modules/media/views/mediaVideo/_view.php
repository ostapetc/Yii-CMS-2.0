<?
$img = $data->getPreview('client_gallery');

if ($img) {
?>
    <li id="File_<?=$data->id?>" style="width: 321px; <?= $index % 3 == 0 ? 'clear:both;' : '' ?>">
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