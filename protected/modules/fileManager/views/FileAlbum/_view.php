<?
$size = array('width' => 142, 'height' => 125);
$img = ImageHelper::thumb($data->path, $data->name, $size, true);
?>

<? if ($img) { ?>
    <li id="File_<?=$data->id?>" class="" style="width: 142px; height: 125px;">
        <a href="<?= $data->getHref() ?>" rel="album_photos" title="asdfkjasfj" class="thumbnail">
            <?
            echo $img;
            ?>
        </a>
    </li>
<? } ?>