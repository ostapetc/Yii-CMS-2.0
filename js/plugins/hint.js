$(function()
{
    $('.hint').each(function()
    {
        var self = $(this),
            a = $('<a href="#" style="background: url(/img/admin/hint.png) no-repeat; width: 16px; height: 16px; display: block; float: left">')
                .click(function(){return false;}).tooltip({
                    placement:'top',
                    title:self.html()
                });

        self.hide();
        self.replaceWith(a);
    });
});