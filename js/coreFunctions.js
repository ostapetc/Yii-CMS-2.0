/**
 * convert this_is_a_string to thisIsAString
 */
String.prototype.underscoreToCamel = function() {
    return this.replace(/(_[a-z0-9])/g, function($1){return $1.toUpperCase().replace('_','');});
};

/**
 * convert this is a string to thisIsAString
 */
String.prototype.toCamel = function() {
    return this.replace('&', 'and').toLowerCase().replace(/( [a-z0-9])/g, function($1){return $1.toUpperCase().replace(' ','');});
};
