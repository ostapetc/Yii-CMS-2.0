$(document).ready(function() {
    $('#webshell').wterm(webshell.wtermOptions);

    $('#webshell input').focus();
    $('html').keydown(function(){
        $('#webshell input').focus();
    });

    var commands = {
        'yiic': webshell.yiicHandlerUrl,
        'exit': function(tokens){
            document.location.href = webshell.exitUrl;
            return 'Bye!';
        },
        'help': function(){
            return webshell.helpText;
        }
    };

    // standard commands
    for (var name in commands) {
        $.register_command(name, commands[name]);
    }

    // configurable commands
    for (var name in webshell.commands) {
        $.register_command(name, webshell.commands[name]);
    }
});