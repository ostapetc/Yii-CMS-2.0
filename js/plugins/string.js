/**
 * Created with JetBrains PhpStorm.
 * User: os
 * Date: 11.07.12
 * Time: 21:59
 * To change this template use File | Settings | File Templates.
 */

String.prototype.trim = function(){
    return this.replace(/^\s+|\s+$/g, "");
};

String.prototype.toCamel = function(){
    return this.replace(/(\-[a-z])/g, function($1){return $1.toUpperCase().replace('-','');});
};

String.prototype.toDash = function(){
    return this.replace(/([A-Z])/g, function($1){return "-"+$1.toLowerCase();});
};

String.prototype.toUnderscore = function(){
    return this.replace(/([A-Z])/g, function($1){return "_"+$1.toLowerCase();});
};