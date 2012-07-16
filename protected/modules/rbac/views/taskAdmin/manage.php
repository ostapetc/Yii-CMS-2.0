<style type="text/css">
    #auth-items h5, #auth-items span {
        /*float: left;*/
    }

    #auth-items .new-auth-item {
        float: right;
        font-weight: bold;
        font-size: 10px;
        color: green;
        clear: both;
    }

    #auth-items hr {
        margin-top: 5px;
        margin-bottom: 5px;
    }

    .operation-name {
        color: gray;
        font-size: 10px;
    }

    .operation-li:hover {
        background-color: #f5f5f5;
    }
</style>

<script type="text/javascript">
    $(function() {
        $('#auth-items h5 input[type=checkbox]').click(function() {
            checkChildCheckbox($(this));
        });

        $('.operation-li input[type=checkbox]').click(function() {
            var parent_chbox = $(this).parents('.task-li:eq(0)').find('h5 input[type=checkbox]');

            if ($(this).is(':checked')) {
                parent_chbox.prop('checked', true);
            }
            else
            {
                var checked_childs = parent_chbox.parents('li:eq(0)').find('.operation-li input[type=checkbox]:checked');
                if (checked_childs.length == 0) {
                    parent_chbox.prop('checked', false);
                }
            }
        });

        function checkChildCheckbox(parent_checkbox) {
            var checked = parent_checkbox.is(':checked');
            var disabled = checked ? false : true;

            parent_checkbox.parents('li:eq(0)').find('ul input[type=checkbox]').attr({
                'checked'  : checked,
                'disabled' : disabled
            });
        }
    });
</script>


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
                    return str_repeat('&nbsp;', 5) . "{$data['description']}";
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
                        array('value' => $data['description'])
                    );
                }
                else
                {
                    return CHtml::checkBox(
                        "AuthItem[{$data['parent']}][operations][{$data['name']}]",
                        $data['exists'],
                        array('value' => $data['description'])
                    );
                }
            },

        )
    )
));
?>


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
