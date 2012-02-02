$(function()
{
    $('#MailerLetter_template_id').change(function()
    {
        var url = location.href.split('/template_id')[0];

        var template_id = $(this).val();
        
        location.href = url + '/template_id/' + template_id;
    });
});
