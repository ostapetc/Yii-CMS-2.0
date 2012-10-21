<?
if(!$data->files_first)
{
    return;
}
?>
<li style="width: <?= MediaAlbum::$users_page_size['width']?>px;">
    <a href="<?= $data->href ?>" class="thumbnail">
        <?
        $preview = $data->files_first->getPreview(MediaAlbum::$users_page_size);
        echo $preview  ? $preview : ImageHelper::placeholder(MediaAlbum::$users_page_size, 'Empty album');
        ?>
        <div class="caption" style="">
            <?= $data->title ?>
        </div>
    </a>
</li>
