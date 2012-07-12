<script type="text/javascript">
    $(function() {
        $('.display-type-select').change(function() {
            location.href = '/page/user/<?= $user_id ?>/widget/' + $(this).val();
        });
    });
</script>

<? if ($is_owner): ?>
    <?= CHtml::dropDownList('widget', $widget, $widgets, array('class' => 'display-type-select', 'style' => 'width: 286px')) ?>
<? endif ?>