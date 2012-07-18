<style type="text/css">
    .items.table b {
        cursor: pointer;
    }
</style>


<script type="text/javascript">
    $(function() {
        /*$('.items.table').find('tr').each(function() {
            if ($(this).find('.operation-chbox').length == 1) {
                $(this).hide();
            }
        });

        $('.items.table b').click(function() {
            var parent = $(this).parents('tr:eq(0)').find('.task-chbox').data('name');

            $('.items.table').find('input[data-parent="' + parent + '"]').each(function() {
                $(this).parents('tr:eq(0)').slideToggle();
            })
        });*/


        $('.operation-chbox').click(function() {
            var parent  = $(this).data('parent');
            var $parent = $('input[data-name="' + parent + '"]');

            if ($(this).is(':checked')) {
                $parent.prop('checked', true);
            }
            else {
                if ($('input[data-parent="' + parent + '"]:checked').length == 0) {
                    $parent.prop('checked', false);
                }
            }
        });
    });
</script>

<?= CHtml::beginForm() ?>

<?
$this->widget('BootGridView', array(
    'dataProvider' => $data_provider,
    'columns'      => array(
        array(
            'header' => 'Задача/Операция',
            'type'   => 'raw',
            'value'  => function($data)
            {
                if (!isset($data['parent']))
                {
                    return "<b>{$data['description']}</b>";
                }
                else
                {
                    return str_repeat('&nbsp;', 5) . "<span data-parent='{$data['parent']}'>{$data['description']}</span>";
                }
            },

        ),
        array(
            'header'      => 'Добавлена',
            'type'        => 'raw',
            'htmlOptions' => array(
                'style' => 'text-align:center'
            ),
            'headerHtmlOptions' => array(
                'style' => 'text-align:center; width: 1px'
            ),
            'value'  => function($data) {
                if (!isset($data['parent']))
                {
                    return CHtml::checkBox(
                        "AuthItem[{$data['name']}][description]",
                        $data['exists'],
                        array(
                            'value'     => $data['description'],
                            'class'     => 'task-chbox',
                            'data-name' => $data['name']
                        )
                    );
                }
                else
                {
                    return CHtml::checkBox(
                        "AuthItem[{$data['parent']}][operations][{$data['name']}]",
                        $data['exists'],
                        array(
                            'value'       => $data['description'],
                            'class'       => 'operation-chbox',
                            'data-parent' => $data['parent']
                        )
                    );
                }
            },

        )
    )
));
?>

<?= CHtml::submitButton(t('сохранить'), array('class' => 'btn btn-primary')); ?>
<?= CHtml::endForm() ?>

<?//= CHtml::beginForm() ?>
<!--<ul id='auth-items'>-->
<!--    --><?// foreach ($tasks as $i => $task): ?>
<!--        <li class="task-li">-->
<!--            <h5>-->
<!--                --><?//= CHtml::checkBox("AuthItem[{$task['name']}][description]", $task['exists'], array('value' => $task['description'])) ?>
<!--                --><?//= $task['description'] ?>
<!--            </h5>-->
<!---->
<!--            --><?// if (!$task['exists']): ?>
<!--                <div class="new-auth-item">--><?//= t('новая задача') ?><!--</div>-->
<!--            --><?// endif ?>
<!---->
<!--            <ul>-->
<!--                --><?// foreach ($task['operations'] as $operation): ?>
<!--                    --><?// if (isset($prefix) && $prefix != array_shift(explode('_', $operation['name']))): ?>
<!--                        <hr/>-->
<!--                    --><?// endif ?>
<!---->
<!--                    --><?//
//                    $prefix = array_shift(explode('_', $operation['name']));
//                    ?>
<!---->
<!--                    <li class='operation-li'>-->
<!--                        --><?//= CHtml::checkBox("AuthItem[{$task['name']}][operations][{$operation['name']}]", $operation['exists'], array('value' => $operation['description'])) ?>
<!--                        <span>--><?//= $operation['description'] ?><!--</span>-->
<!--                        <span class="operation-name">(--><?//= $operation['name'] ?><!--)</span>-->
<!---->
<!---->
<!---->
<!--                        --><?// if (!$operation['exists']): ?>
<!--                            <div class="new-auth-item">--><?//= t('новая операция') ?><!--</div>-->
<!--                        --><?// endif ?>
<!--                    </li>-->
<!--                --><?// endforeach ?>
<!--            </ul>-->
<!--        </li>-->
<!--    --><?// endforeach ?>
<!--</ul>-->
<br/>

<?//= CHtml::submitButton(t('сохранить'), array('class' => 'btn btn-primary')); ?>

<?//= CHtml::endForm() ?>
