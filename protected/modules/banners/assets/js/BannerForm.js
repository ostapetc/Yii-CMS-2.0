$(function()
{
    var src = $('#Banner_src').val();
    if (src.length > 0)
    {
        $('#Banner_image').after("<br/>" + src);
    }

    var $banner_url = $('#Banner_url');

    showDatesInputsIfUsed();

    $('#Banner_date_active').change(showDatesInputsIfUsed);

    var text = "Вы можете задать даты, в которые баннер будет отображаться.<br/>";
        text+= "<b>Дата начала показа</b> - дата с которой баннер будет отображаться на сайте.<br/>";
        text+= "<b>Дата окончания показа</b> - дата в которую баннер будет скрыт с сайта.";

    var hint_div = $('<div></div>').css({
        'position'     : 'absolute',
        'border-left'  : '2px solid #E0E0E0',
        'top'          : '0',
        'left'         : '200px',
        'padding-left' : '10px'
    }).html(text);

    $('#Banner_date_start').closest('dl').css('position', 'relative').append(hint_div);

    function showDatesInputsIfUsed()
    {
        var parent = $('#Banner_date_start').closest('dl').add(
            $('#Banner_date_end').closest('dl')
        );

        if ($('#Banner_date_active').is(':checked'))
        {
            parent.slideToggle();
        }
        else
        {
            $('#Banner_date_start, #Banner_date_end').val('');
            parent.slideToggle();
        }
    }

    $('#Banner_page_id').change(function()
    {
        if ($(this).val().length == 0)
        {
            $banner_url.attr('readOnly', false);
        }
        else
        {
            $banner_url.val('');
            $banner_url.attr('readOnly', true);
        }
    });

    $('#Banner_url').after("<br/><br/><a href='' id='reset_urls'>Сбросить переход по баннеру</a>");

    $('#reset_urls').click(function()
    {
        $('#Banner_page_id').val('');
        $('#Banner_url').attr('readOnly', false).val('');
        return false;
    });

    var section_text = "<div style='color: #666666;margin-top: 20px'>";
        section_text+= "Пожалуйста, выберите разделы или задайте URL-адрес по которому <br/>";
        section_text+= "будет переходить пользователь при «клике» на баннер.";
        section_text+= "</div>";

    $('#Banner_name').after(section_text);
});
