$(function()
{
    $('.admin_link').click(function()
    {
        var href = $(this).attr('href');
        location.href = "/main/mainAdmin/AdminLinkProcess?url=" + href;
        return false;
    });
});