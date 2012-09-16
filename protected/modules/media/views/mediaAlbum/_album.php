<li style="width: <?= MediaAlbum::$users_page_size['width']?>px">
    <a href="<?= $data->href ?>" class="thumbnail">
        <?
        if ($file = $data->files_first)
        {
            echo ImageHelper::thumb($file->path, $file->name, MediaAlbum::$users_page_size, true);
        }
        else
        {
            echo ImageHelper::placeholder(MediaAlbum::$users_page_size, 'Empty album');
        }
        ?>
        <div class="caption" style="">
            <?= $data->title ?>
        </div>
    </a>
</li>