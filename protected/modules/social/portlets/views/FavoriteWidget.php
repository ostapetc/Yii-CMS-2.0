<? if (Yii::app()->user->isGuest): ?>
    <?=
    CHtml::link('', '', array(
        'title'   => $guest_msg,
        'onclick' => 'return false',
        'class'   => 'guest glyphicon-dislikes'
    ));
    ?>
<? else: ?>
    <?=
    CHtml::link('', '', array(
        'title'     => $user_msg,
        'model_id'  => $model_id,
        'object_id' => $object_id,
        'class'     => 'favorite ' . ($added ? 'glyphicon-star' : 'glyphicon-dislikes')
    ));
    ?>
<? endif ?>

<a href="#"  title="<?= $count_msg ?>" class="favs_count" id="favs_count_<?= $object_id ?>_<?= $model_id ?>"><?= $count ?> в избранном</a>
