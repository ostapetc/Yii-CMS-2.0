<?
$this->tabs = array(
    'добавить роль' => $this->createUrl('create')
);
?>

<script type="text/javascript">
    $(function() {
        var confirm_msg = '<?= t('Удаление роли может привести к неработоспособности системы! Удалить роль?'); ?>';

        $('.delete-role').click(function() {
            if (confirm(confirm_msg)) {
                $.post($(this).attr('href'), function() {
                    location.href = '';
                })
            }

            return false;
        });
    });
</script>

<table class="table table-striped table-bordered table-condensed">
    <tr>
        <th><?= t('Имя') ?></th>
        <th><?= t('Описание') ?></th>
        <th width="50"></th>
    </tr>
    <? foreach ($roles as $role): ?>
        <tr>
            <td>
                <?= $role->name ?>
            </td>
            <td>
                <?= $role->description ?>
            </td>
            <td>
                <?= CHtml::link(CHtml::image('/img/admin/update.png'), array('update', 'name' => $role->name)) ?>
                &nbsp;
                <?= CHtml::link(CHtml::image('/img/admin/delete.png'), array('delete', 'name' => $role->name), array("class" => "delete-role")) ?>
            </td>
        </tr>
    <? endforeach ?>
</table>