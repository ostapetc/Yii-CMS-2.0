<?
$img = $data->getPreview(['width' => 320, 'height' => 260]);

if ($img) {
?>
    <li id="File_<?=$data->id?>" style="width: 331px;">
        <?
        echo CHtml::tag('span', [
            "rel" => "album_photos",
            "title" => $data->title,
            "class" => "thumbnail",
            "data-object-id" => get_class($data),
            "data-model-id" => $data->id,
            "data-model-tag" => 'files',
        ], $img);
        ?>
        <div class="published"><?= Yii::app()->dateFormatter->formatDateTime($data->date_create, 'long', 'short') ?></div>

        <? $this->widget('social.portlets.FavoritePortlet', array('model' => $data)); ?>

        <?
        $user = $data->getParentModel();
        if ($user instanceof User)  {
        ?>
            <div class="author" >
                <a href="<?= $user->url ?>" title="Автор текста"><span class="glyphicon-user"></span><?= $user->name ?></a>
                <span title="рейтинг пользователя" class="rating"><?= $user->rating ?></span>
            </div>
        <? } ?>

        <div class="comments">
            <?
            $title = $data->comments_count ? 'Читать комментарии' : 'Комментировать';
            ?>

            <a href="<?= $data->url ?>#comments" title="<?= $title ?>">
                <span class="glyphicon-comments"></span>&nbsp;
                <span class="all"><?= $data->comments_count ? $data->comments_count : $title ?></span>
            </a>
        </div>

    </li>
<? } ?>