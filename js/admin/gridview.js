$(function()
{
    $('.pager_select').change(function()
    {
        var params = '/model/' + $(this).attr('model') + '/per_page/' + $(this).val() + '/back_url/' + $("#back_url").val();
        location.href = '/main/mainAdmin/SessionPerPage' + params;
    });


//    $(".delete").click(function()
//    {
//    	if (confirm('Удалить объект?'))
//    	{
//    		return true;
//    	}
//
//    	return false;
//	});
});