<?
$size = array('width' => 130, 'height' => 117);
$img = ImageHelper::thumb($data->path, $data->name, $size, true);
?>

<? if ($img) { ?>
    <li class="" style="width: 117px; height: 130px;">
        <a href="<?= $data->getHref() ?>" rel="album_photos" title="asdfkjasfj" class="thumbnail">
            <?
            echo $img;
            ?>
        </a>
    </li>
<? } ?>