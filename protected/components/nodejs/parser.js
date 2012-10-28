$ = require('jQuery');

$.get('http://cmf2.ru/', {}, function(data) {
    console.log(data);
}, 'html');