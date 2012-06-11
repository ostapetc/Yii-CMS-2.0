<li class="span3" style="width: 255px">
    <a href="<?= $data->href ?>" class="thumbnail">
        <?
        $size = array('width' => 255, 'height' => 220);
        if ($file = $data->files_first)
        {
            echo ImageHelper::thumb($file->path, $file->name, $size, true);
        }
        else
        {
            echo CHtml::image(ImageHelper::placeholder($size, 'Empty album'), '', $size);
        }
        ?>
        <div class="caption" style="">
            <?= $data->title ?>
        </div>
    </a>
</li>