<div class="content-type">
    <?
        switch ($data->model->type) {
            case MediaFile::TYPE_VIDEO:
                echo 'Видео: ';
                break;
            case MediaFile::TYPE_AUDIO:
                echo 'Аудио: ';
                break;
        }
    ?>
</div>
<div class="preview">
    <?= $data->model->getPreview() ?>
</div>

<div class="title">
    <a href="<?= $data->model->url ?>">
        <?= $data->model->title ?>
    </a>
</div>
