<li class="gallery-item" style="width: <?= MediaAlbum::$users_page_size['width']?>px; height: <?= MediaAlbum::$users_page_size['height'] + 60 ?>px;">
    <a href="<?= $data->href ?>" class="thumbnail">
        <div class="gallery-title">
            <span>
                <?= $data->title ?>
            </span>
        </div>
        <?
        if ($data->files_first) {
            $preview = $data->files_first->getPreview(MediaAlbum::$users_page_size);
            echo $preview  ? $preview : ImageHelper::placeholder(MediaAlbum::$users_page_size, 'Empty album');
        }
        ?>
    </a>
</li>