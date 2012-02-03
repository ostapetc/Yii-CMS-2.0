(function($)
{
    $.fn.clientForm = function()
    {
        var self = $(this);
    };

})(jQuery);

$(document).ready(function()
{
    $('label').filter(function() {
        return !($(this).siblings('select, input[type=checkbox], input[type=radio]').length > 0);
    }).addClass('inFieldLabels').inFieldLabels();
});
