var jsdom = require('jsdom').jsdom,
    myWindow = jsdom().createWindow();
console.log(myWindow);
myWindow['a'] = 'b';
console.log(myWindow);
http.get('http://cmf2.ru/', function(data) {
    console.log(data);
});
