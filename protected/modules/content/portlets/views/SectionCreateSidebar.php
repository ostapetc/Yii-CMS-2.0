<script type="text/javascript">
    $(function() {
        $('#PageSection_submit').click(function() {
            var params = {
                'PageSection[name]'      : $('#PageSection_name').val(),
                'PageSection[parent_id]' : $('#PageSection_parent_id').val()
            }

            $.post('/content/PageSection/create', params, function(res) {
                if (res.done) {
                    alert('Раздел добавлен');
                }
                else {
                    alert(res.errors.join("\n"));
                }
            }, 'json');
        });
    });
</script>

<h3>Добавить раздел</h3>
<br/>

<?= CHtml::textField('name', null, array('placeholder' => 'Название', 'style' => 'width: 250px', 'id' => 'PageSection_name')); ?>
<?= CHtml::dropdownList('parent_id', null, PageSection::model()->optionsTree(), array('empty' => 'родительский раздел', 'style' => 'width: 260px !important', 'id' => 'PageSection_parent_id')); ?>
<?= CHtml::button('добавить', array('class' => 'btn btn-success', 'id' => 'PageSection_submit')); ?>