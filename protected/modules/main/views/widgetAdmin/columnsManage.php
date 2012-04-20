<style type="text/css">
    .columns_fieldset {
        float:left;
        margin-right: 20px;
    }

    .columns_fieldset ul {
        min-height: 150px;
        margin-left: 10px;
    }

    .columns_fieldset ul li {
        margin-bottom: 5px;
    }

    .columns_fieldset .btn.field{
        font-size: 12px !important;
        line-height: 12px !important;
    }

</style>

<script type="text/javascript">
    $(function() {
        $('.columns').sortable({
            'connectWith' : '.columns'
        });

        $('#save_button').click(function() {
            var attributes = new Array();

            $('.columns.visible a').each(function() {
                attributes.push($(this).attr("attribute"));
            });

            if (attributes.length > 0) {
                $('#columns_form').append("<input type='hidden' name='columns' value='" + attributes.join(',') + "' />").submit();
            }
            else {
                alert('Требуется хотябы одно видимое поле!');
            }
        });
    });
</script>

<form method="post" id="columns_form"></form>

<fieldset class="columns_fieldset">
    <label>Видимые поля</label>
    <ul class="columns visible">
    <? foreach ($visible_columns as $name => $label): ?>
        <li class="column-li">
            <a class="btn field" attribute="<?= $name ?>"><?= $label ?></a>
        </li>
    <? endforeach ?>
    </ul>

    <div style="margin-left: 10px">
        <input type="button" name="submit" class="btn btn-primary" value="сохранить" id="save_button">
        <a id="yt0" class="back_button btn btn-danger" href="#">Отмена</a>
    </div>
</fieldset>

<fieldset class="columns_fieldset">
    <label>Невидимые поля</label>
    <ul class="columns">
    <? foreach ($hidden_columns as $name => $label): ?>
        <li class="column-li">
            <a class="btn field" attribute="<?= $name ?>"><?= $label ?></a>
        </li>
    <? endforeach ?>
    </ul>
</fieldset>

<br clear="all"/>

