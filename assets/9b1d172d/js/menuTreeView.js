$(function()
{
	$('.delete_menu_link').live('click', function()
	{
		if (confirm('Удалить ссылку?')) 
		{
			location.href = '/content/menuLinkAdmin/delete/id/' + $(this).attr('link_id');
		}
		
		return false;
	});
});