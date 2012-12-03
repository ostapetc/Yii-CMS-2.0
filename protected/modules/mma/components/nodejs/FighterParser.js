var Crawler = require("crawler").Crawler;

var mongo  = require('mongodb'),
    Server = mongo.Server,
    Db     = mongo.Db;

var server = new Server('localhost', 27017, {auto_reconnect: true});
var db     = new Db('mma', server);

var pages = {};

db.open(function(err, db) {
    if(!err) {
        console.log("We are connected");
    }
    else {
        console.log('Mongo Error: ' + err);
        return false;
    }

    db.createCollection('fighters', function(err, collection) {
        var c = new Crawler({
            "maxConnections" : 10,
            "callback"       : function(error,result,$) {
                if (error) {
                    console.log("ERROR: " + error);
                }

                $("a[href^='http://www.sherdog.com/fighter/']").each(function() {
                //$("a").each(function() {
                    var href = $(this).attr('href');

                    if (!pages[href] || ((new Date().getTime() - pages[href]) >= 1000 * 60*60)) {
                        pages[href] = new Date().getTime();
                        c.queue(href);
                        console.log(href);

                        if ($('.module.bio_fighter.vcard').length > 0) {
                            var fights = $('div.left_side>.bio_graph>.graph_tag');

                            var id = /-([0-9]+)$/.exec($('meta[property="og:url"]').attr('content'));
                            id = id[1];

                            collection.findOne({'id' : id}, function (err, item) {
                                var attributes = {
                                    'id'               : id,
                                    'name'             : $('span.fn').html(),
                                    'nickname'         : $('span.nickname em').html(),
                                    'birthdate'        : $('span.birthday span').html(),
                                    'city'             : $('span.locality').html(),
                                    'height'           : $('span.height strong').html().replace("'", '.').replace('"', ''),
                                    'weight'           : $('span.weight strong').html().replace("lbs", ''),
                                    'class'            : $('h6.wclass strong').html(),
                                    'association'      : $('h5.association span a span').html(),
                                    'wins'             : $('div.bio_graph .counter').html(),
                                    'losses'           : $('div.bio_graph.loser .counter').html(),
                                    'win_ko'           : parseInt($(fights[0]).html()),
                                    'win_submissions'  : parseInt($(fights[1]).html()),
                                    'win_decisions'    : parseInt($(fights[2]).html()),
                                    'loss_ko'          : parseInt($(fights[3]).html()),
                                    'loss_submissions' : parseInt($(fights[4]).html()),
                                    'loss_decisions'   : parseInt($(fights[5]).html()),
                                    'image'            : $('img.profile_image.photo').attr('src'),
                                    'date_update'      : new Date().getTime()
                                }

                                if (item) {
                                    collection.update({_id : item._id}, attributes);
                                    console.log('updated');
                                }
                                else  {
                                    collection.insert(attributes);
                                }
                            });
                        }
                    }
                });
            }
        });

        c.queue("http://www.sherdog.com");
    });
});


