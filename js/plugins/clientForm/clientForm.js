(function($)
{
    $.fn.clientForm = function()
    {
        var self = $(this);
        self.tipInput();
    };

})(jQuery);

$(document).ready(function()
{
    $('label').inFieldLabels();
});
