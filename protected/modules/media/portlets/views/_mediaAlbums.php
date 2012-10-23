<?
if(!$data->files_first)
{
    return;
}
?>
<li>
    <a href="<?= $data->href ?>" class="thumbnail">
        <?
        $preview = $data->files_first->getPreview(MediaAlbum::$sidebar_size);
        echo $preview  ? $preview : ImageHelper::placeholder(MediaAlbum::$sidebar_size, 'Empty album');
        ?>
        <div class="caption" style="">
            <?= $data->title ?>
        </div>
    </a>
</li>
