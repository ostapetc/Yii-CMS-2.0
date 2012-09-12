<li style="width: <?= MediaAlbum::$album_size['width']?>px">
    <a href="<?= $data->href ?>" class="thumbnail">
        <?
        if ($file = $data->files_first)
        {
            echo ImageHelper::thumb($file->path, $file->name, MediaAlbum::$album_size, true);
        }
        else
        {
            echo ImageHelper::placeholder(MediaAlbum::$album_size, 'Empty album');
        }
        ?>
        <div class="caption" style="">
            <?= $data->title ?>
        </div>
    </a>
</li>