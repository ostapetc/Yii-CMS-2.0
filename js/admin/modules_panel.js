$(document).ready(function()
{
    $(".btn-slide").click(function()
    {
        $("#panel").slideToggle("slow");
        $(this).toggleClass("active"); return false;
    });
    
    $('.module_div').each(function() 
    {
        var id = $(this).find('.vs-context-menu').attr("id");
        
        $(this).vscontext({menuBlock: id});
    });    
});
