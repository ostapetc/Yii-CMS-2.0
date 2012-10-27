<?
if (!$data->files_first)
{
    return;
}
?>
<li class="gallery-item sidebar-galery-item">
    <a href="<?= $data->href ?>" class="thumbnail">
        <div class="gallery-title">
            <span>
                <?= $data->title ?>
            </span>
        </div>
        <?
        $preview = $data->files_first->getPreview(MediaAlbum::$sidebar_size);
        echo $preview ? $preview : ImageHelper::placeholder(MediaAlbum::$sidebar_size, 'Empty album');
        ?>
    </a>
</li>
