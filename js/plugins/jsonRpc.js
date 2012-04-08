var server = {};
function JsonRpc () {
    this.__url = '/content/json';
    this.__async = true;
    this.__call = function(method, args)
    {
        var data = {
            'type' : 'json-rpc 2.0',
            'params' : args,
            'method' : method
        };

        var settings = {
            contentType: 'application/json',
            dataType: 'json',
            async: this.__async,
            type: 'post',
            data: JSON.stringify(data),
//            processData: false,
            url: this.__url
        };
        if (this.__async)
        {
            return $.ajax(settings)
                .error(function() {

                })
                .promise();
        }
        else
        {
            return $.ajax(settings).responseText;
        }
    };
    return this;
};


function ServerApi (modelName, methods)
{
    var model = new JsonRpc();
    for (var method in methods) {
        model[method] = function() {return model.__call(method, arguments)};
    }
    server[modelName] = model;
    this.onComplete = function(){

        //sync
//        var name = server.tmp.getName('Anya');
//        alert(name);

        //    async
        server.tmp.getName('Anya').done(function(result){
            alert($.parseJSON(result));
            for(var a in result)
            {
                alert(result[a]);
            }
        });
    };

    this.onComplete();
};

