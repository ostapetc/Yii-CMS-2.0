$(function() 
{   	
	$('.assign_select').change(function() 
	{
		var user_id = $(this).attr('user_id');
		var role    = $(this).val();

		$.post('/rbac/roleAdmin/assignment', { user_id : user_id, role : role }); 
	});

	
	if (/create|update/.test(location.href)) 
	{	
		setTimeout(function() 
		{
			var childs = $.parseJSON($('#childs').val());
		
			for (var i in childs) 
			{
				var child = childs[i].child; 
	
				$('.available.connected-list').find('li[value=' + child + ']').attr("style", "display:block;color:green");
			}
		
		}, 1000);	
	}
});
