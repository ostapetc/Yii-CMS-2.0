$(function()
{
    $(".tablesorter").tablesorter();
    $(".tab_content").hide();
    $(".tab_content:first").show();

    $("ul.tabs li").click(function() {
        $("ul.tabs li").removeClass("active");
        $(this).addClass("active");
        $(".tab_content").hide();

        var activeTab = $(this).find("a").attr("href");
        $(activeTab).fadeIn();

        return false;
    });

    $('.column').equalHeight();

    $(".btn-success, .btn_view_site").each(function() {
        $(this).html($(this).html().toLowerCase());
    });
});