<script type="text/javascript">
    $(function() {
        $('#Tag_submit').click(function() {
            $.post('/tags/Tag/create', { 'Tag[name]' : $('#Tag_name').val() }, function(res) {
                if (res.done) {
                    $page_tags = $('#Page_tags');
                    if ($page_tags.length)
                    {
                        var options = "";

                        for (var id in res.tags)
                        {
                            options+= "<option value='" + id + "'>" + res.tags[id] + "</option>";
                        }

                        $page_tags.html(options);
                        $page_tags.trigger("liszt:updated");
                    }

                    $('#Tag_name').val('');
                    alert('Тег добавлен');
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

<h4>Добавить тег</h4>

<?= CHtml::textField('name', null, array('placeholder' => 'Название', 'style' => 'width: 250px', 'id' => 'Tag_name')); ?>
<?= CHtml::button('добавить', array('class' => 'btn btn-success', 'id' => 'Tag_submit')); ?>
