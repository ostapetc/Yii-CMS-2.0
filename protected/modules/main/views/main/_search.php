<script type="text/javascript">
    $(function()
    {
        var $editbox_search = $('#editbox_search');
        var search_def_val  = $editbox_search.attr('def_val');

        $editbox_search.bind({
            'focus': function()
            {
                if ($(this).val() == search_def_val)
                {
                    $(this).val('');
                }
            },

            'blur': function()
            {
                if ($(this).val() == '')
                {
                    $(this).val(search_def_val);
                }
            }
        });
    });
</script>

<?php
$def_value = Yii::t('main', 'Поиск по сайту');
if (isset($_GET['query']))
{
    $search_value = addslashes(strip_tags($_GET['query']));
}
else
{
    $search_value = $def_value;
}
?>
<div class="searchform">
    <form id="formsearch" name="formsearch" method="get" action="<?php echo $this->url('/search'); ?>">
        <span>
            <input name="query" class="editbox_search" id="editbox_search" maxlength="80" value="<?php echo $search_value; ?>" def_val="<?php echo $def_value; ?>" type="text"/>
        </span>
        <input name="button_search" src="/images/site/search_btn.gif" class="button_search" type="image"/>
    </form>
</div>
