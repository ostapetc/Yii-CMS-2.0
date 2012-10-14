/**
 * convert this_is_a_string to thisIsAString
 */
String.prototype.underscoreToCamel = function()
{
    return this.replace(/(_[a-z0-9])/g, function($1)
    {
        return $1.toUpperCase().replace('_', '');
    });
};

/**
 * convert this is a string to thisIsAString
 */
String.prototype.toCamel = function()
{
    return this.replace('&', 'and').toLowerCase().replace(/( [a-z0-9])/g, function($1)
    {
        return $1.toUpperCase().replace(' ', '');
    });
};


/**
 * remove all tags
 */
String.prototype.stripTags = function()
{
    return this.replace(/<\/?[^>]+>/gi, '');
}

String.prototype.addGetParams = function(data)
{
    var query = this.split("?");
    var cleanData = [];
    for (i in data)
    {
        cleanData[encodeURIComponent(i)] = data[encodeURIComponent(i)];
    }


    if (query[1] && query[1].length > 0)
    {
        var parameters, x;
        for (var i in query[1])
        {
            x = query[1][i].split('=');
            parameters[x[0]] = x[1];
        }

        data = $.merge(parameters, data);
    }

    var res = [];
    for (var i in data)
    {
        res.push(i + '=' + data[i]);
    }
    return this.substr(0, 0).concat(query[0] + '?' + res.join('&'));
}