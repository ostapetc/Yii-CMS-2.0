<?
$img = $data->getPreview(['width' => 320, 'height' => 260]);

if ($img) {
?>
<li id="File_<?=$data->id?>" style="width: 331px;" class="gallery-item">
    <a class="thumbnail" href="<?= $this->createUrl('/media/mediaVideo/view', ['id' => $data->id]) ?>">
        <div class="gallery-title">
            <span>
                <?= $data->title ? $data->title : '&nbsp;' ?>
            </span>
        </div>
        <?= $img ?>
    </a>
    <div class="infopanel-wrapper">
        <div class="infopanel">
            <div class="voting">
                <? $this->widget('social.portlets.RatingPortlet', array('model' => $data)); ?>
            </div>

            <div class="published"><?= Yii::app()->dateFormatter->formatDateTime($data->date_create, 'long', 'short') ?></div>

            <? $this->widget('social.portlets.FavoritePortlet', array('model' => $data)); ?>

            <div class="comments">
                <span class="glyphicon-comments"></span>
                <span class="all">(<?= $data->comments_count ?>)</span>
            </div>
            <?
            $user = $data->getParentModel();
            if ($user instanceof User)  {
                ?>
                <div class="author" >
                    <a href="<?= $user->url ?>" title="Автор текста"><span class="glyphicon-user"></span><?= $user->name ?></a>
                    <span title="рейтинг пользователя" class="rating"><?= $user->rating ?></span>
                </div>
            <? } ?>

        </div>
    </div>

</li>
<? } ?>