$(function()
{
    $('.role_link').click(function()
    {
        $(this).parents('td:eq(0)').find('.uch_tbl').slideToggle('fast');
        return false;
    });
    
    
    $('.role_checkbox').click(function() 
	{
    	var checked = $(this).attr('checked');
    	
    	$(this).parents('tr:eq(0)').find('.user_checkbox').attr('checked', checked);
	});


    $('.role_checkbox').each(function()
    {
        var parent_tr = $(this).parents('tr:eq(0)');

        if (parent_tr.find('.user_checkbox').length = parent_tr.find('.user_checkbox:checked').length)
        {
            $(this).attr('checked', true);
        }
    });
});