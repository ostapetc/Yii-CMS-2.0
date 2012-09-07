<script type="text/javascript">
    $(function() {
        $('#PageSection_submit').click(function() {
            var params = {
                'PageSection[name]'       : $('#PageSection_name').val(),
                'PageSection[parent_id]' : $('#PageSection_parent_id').val(),
                'ajax'                      : 1
            }

            $.post('/content/PageSection/create', params, function(res) {
                if (res.done) {
                    $sections_ids = $('#Page_sections_ids');
                    if ($sections_ids.length)
                    {
                        var options = "";

                        for (var id in res.sections)
                        {
                            options+= "<option value='" + id + "'>" + res.sections[id] + "</option>";
                        }

                        $sections_ids.html(options);
                        $sections_ids.trigger("liszt:updated");
                    }

                    $('#PageSection_name').val('');
                    $('#PageSection_parent_id').val('')

                    alert('Раздел добавлен');
                }
                else {
                    var errors_msg = '';

                    for (var i in res.errors)
                    {
                        errors_msg+= res.errors[i].error + " \n";
                    }

                    alert(errors_msg);
                }
            }, 'json');
        });
    });
</script>

<h4>Добавить раздел</h4>

<?= CHtml::textField('name', null, array('placeholder' => 'Название', 'style' => 'width: 250px', 'id' => 'PageSection_name')); ?>
<?= CHtml::dropdownList('parent_id', null, PageSection::model()->optionsTree(), array('empty' => 'родительский раздел', 'style' => 'width: 260px !important', 'id' => 'PageSection_parent_id')); ?>
<?= CHtml::button('добавить', array('class' => 'btn btn-success', 'id' => 'PageSection_submit')); ?>