$(function()
{  
    initFiltersLink();

    $('.pager_select').live('change', function()
    {
    	var params = '/model/' + $(this).attr('model') + '/per_page/' + $(this).val() + '/back_url/' + $("#back_url").val();
    	location.href = '/main/mainAdmin/SessionPerPage' + params;
    });      
    
    if ($('.grid-view table').attr('sortable'))
    {
        makeSortable();
    }
    
    if ($('.grid-view table').attr('mass_removal'))
    {
    	enableMassRemoval();
    }    
});


function initFiltersLink()
{
    $('.filters input').each(function()
    {
        if ($(this).val())
        {
            $(this).parents('table:eq(0)').find('.filters').slideToggle();
        }
    });

    $('.grid-view th').each(function()
    {
        if ($(this).html() == '&nbsp;')
        {
            $(this).html("<a href='' class='filters_link'>фильтры</a>");

            $('.filters_link').click(function()
            {
                $(this).parents('table:eq(0)').find('.filters').slideToggle();
                return false;
            });
        }
    });
}


function makeSortable()
{
    var fixHelper = function(e, ui)
    {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };

    $(".grid-view tbody").sortable({helper: fixHelper}).disableSelection();
}


function enableMassRemoval() 
{
	$('.object_checkboxes').live('click', function() 
	{
		$('.object_checkbox').attr('checked', $(this).attr('checked'));
	});
	
	$('#mass_remove_button').live('click', function() 
	{
		var $checkboxes = $('.object_checkbox:checked');

		if ($checkboxes.length > 0) 
		{
			if (!confirm('Вы уверены, что хотите удалить отмеченные элементы?')) 
			{
				return false;
			}
			
			showLoader();
			
			var grid_id = $('.grid-view').attr('id');
			
			$checkboxes.each(function() 
			{	
				var action = $(this).parents('tr:eq(0)').find('.delete').attr('href');
				
				$.fn.yiiGridView.update(grid_id, {
					type: 'POST',
					url : action,
					success: null
				});
			});
			
			$(document).ajaxStop(function() {
				$.fn.yiiGridView.update(grid_id);
				hideLoader();
				$(this).unbind('ajaxStop');
			});				
		}
		else 
		{
			showMsg('Отметьте элементы!');
		}
	});
}