<script type="text/javascript">
    $(function() {
        $('#nagigate_section_btn').click(function() {
            var section = $('#nagigate_section').val();
            if (section)  {
                location.href = '/page/section/' + section;
            }
        });
    });
</script>

<h3>Навигатор</h3>
<br/>

<?= CHtml::dropdownList('nagigate_section', null, $sections, array('style' => 'width: 260px', 'empty' => 'выберите раздел')) ?>
<?= CHtml::button('посмотреть', array('class' => 'btn btn-success', 'id' => 'nagigate_section_btn')); ?>