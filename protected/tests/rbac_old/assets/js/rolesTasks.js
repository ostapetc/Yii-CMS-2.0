$(function()
{
    $('.links_td a').click(function()
    {
        var action = $(this).attr('class').replace('_link', '');

        var config = {
            'deny' : {
                tr_class   : 'deny_tr',
                link_text  : 'Разрешить',
                link_class : 'allow_link'
            },
            'allow' : {
                tr_class   : 'allow_tr',
                link_text  : 'Запретить',
                link_class : 'deny_link'
            }
        }

        $(this).text(config[action].link_text).attr('class', config[action].link_class);

        var parent_tr = $(this).parents('tr:eq(0)');

        parent_tr.attr('class', config[action].tr_class);

        var params = {
            task : parent_tr.attr('task'),
            role : $('#curr_role').val()
        }

        $.post('/rbac/TaskAdmin/' + action, params);

        return false;
    });
});