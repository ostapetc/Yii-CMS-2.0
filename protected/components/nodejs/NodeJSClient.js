$.fn.coreNodeJSClient = function(options)
{
    var connectUrl = "http://" + options.host + ':' + options.port;
    if (options.namespace)
    {
        connectUrl += '/' + options.namespace;
    }
    var socket = io.connect(connectUrl);
    socket.on('request_user_id', function(a)
    {
        alert(2);
        socket.emit('response_user_id', {user_id: $('#app_user_id').val()});
    });

    socket.on('new_message', function(res)
    {
        alert(1);
    });
}
