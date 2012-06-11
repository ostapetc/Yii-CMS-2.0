<?
$size = array('width' => 134, 'height' => 125);
$img = ImageHelper::thumb($data->path, $data->name, $size, true);
if ($img) { ?>
    <li id="File_<?=$data->id?>" style="width: 134px; height: 120px;">
        <a href="<?= $data->getHref() ?>" rel="album_photos" title="asdfkjasfj" class="thumbnail">
            <?
            echo $img;
            ?>
        </a>
    </li>
<? } ?>