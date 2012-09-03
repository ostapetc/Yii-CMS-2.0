<div class="favorite">
    <? if (Yii::app()->user->isGuest): ?>
        <a title="<?= $guest_msg ?>" onclick="return false;" href="#" class="guest glyphicon-star"></a>
    <? else: ?>
        <? if ($added): ?>
            <a title="<?= $added_msg ?>" onclick="return false;" href="#" class="added glyphicon-star"></a>
        <? else: ?>
            <a title="<?= $user_msg ?>" added_msg="<?= $added_msg ?>" model_id="<?= $model_id ?>" object_id="<?= $object_id ?>" href="" class="user glyphicon-star "></a>
        <? endif ?>
    <? endif ?>
</div>

<div title="<?= $count_msg ?>" class="favs_count" id="favs_count_<?= $object_id ?>_<?= $model_id ?>"><?= $count ?></div>
