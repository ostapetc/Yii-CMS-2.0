<script type="text/javascript">
    $(function() {
        $('#auth-items input[type=checkbox]').click(function() {
            var childs = $(this).parents('li:eq(0)').find('ul input');

            if (childs.length) {
                if ($(this).is(':checked')) {
                    childs.each(function() {
                        $(this).prop('checked', true);
                        $(this).prop('readonly', true);
                    });
                }
                else {
                    childs.each(function() {
                        $(this).prop('checked', false);
                        $(this).prop('readonly', false);
                    });
                }
            }
        });
    });
</script>

<?
$auth_item = AuthItem::model()->find("name = 'content'");
?>

<?= CHtml::beginForm() ?>
<ul id='auth-items'>
    <? foreach ($tasks as  $task): ?>
        <li>
            <h5>
                <?= CHtml::checkBox("AuthItem[{$task['name']}][description]", $task->allowForRole($role), array('value' => $task['description'])) ?>
                <?= $task['description'] ?>
            </h5>

            <? if ($task->operations): ?>
                <ul>
                    <? foreach ($task->operations as $operation): ?>
                        <? if (isset($prefix) && $prefix != array_shift(explode('_', $operation['name']))): ?>
                            <hr/>
                        <? endif ?>

                        <?
                        $prefix  = array_shift(explode('_', $operation['name']));
                        ?>

                        <li>
                            <?=
                            CHtml::checkBox(
                                "AuthItem[{$task['name']}][operations][{$operation['name']}]",
                                $operation->allowForRole($role),
                                array(
                                    'value' => $operation['description']
                                )
                            )
                            ?>
                            <span><?= $operation['description'] ?></span>
                        </li>
                    <? endforeach ?>
                </ul>
            <? endif ?>
        </li>
    <? endforeach ?>
</ul>

<br/>

<?= CHtml::submitButton(t('сохранить'), array('class' => 'btn btn-primary')); ?>

<?= CHtml::endForm() ?>
