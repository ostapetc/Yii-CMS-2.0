$(function()
{
    $('.deactivate_module, .activate_module').click(function()
    {
        var class  = $(this).attr('module_class');
        var name   = $(this).attr('name');
        var action = $(this).attr('action');

        var messages = {
            'activateModule'   : 'Активировать модуль: ' + name + '?',
            'deactivateModule' : 'Деактивировать модуль: ' + name + '? \n Внимание! Все данные этого модуля будут удалены!'
        }

        if (confirm(messages[action]))
        {
            location.href = '/main/mainAdmin/' + action + '/class/' + class;
        }
    });
});