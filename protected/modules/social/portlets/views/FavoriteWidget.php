<?=
CHtml::link('', '', [
    'title'       => $user_msg,
    'class'       => 'favorite ' . ($added ? 'glyphicon-star' : 'glyphicon-dislikes'),
    'data-model'  => $model_id,
    'data-object' => $object_id,
    'data-role'   => User::ROLE_USER
]);
?>

<a href="#"  title="<?= $count_msg ?>" class="favs_count" id="favs_count_<?= $object_id ?>_<?= $model_id ?>"><?= $count ?> в избранном</a>
