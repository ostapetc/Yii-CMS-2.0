var Crawler = require("crawler").Crawler;

var mongo  = require('mongodb'),
    Server = mongo.Server,
    Db     = mongo.Db;

var server = new Server('127.0.0.1', 27017, {auto_reconnect: true, w: 'majority'});
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

    db.createCollection('log', function(err, log_collection) {
        if (err) {
            console.log('error creating log collection: ' + err);
            return false;
        }

        db.createCollection('fighters', function(err, fighters_collection) {
            if (err) {
                console.log('error creating fighters');
                return false;
            }

            fighters_collection.ensureIndex({'id': 1}, {unique:true});

            db.createCollection('events', function(err, events_collection) {
                if (err) {
                    console.log('error creating events collection: ' + err);
                    return false;
                }

                events_collection.ensureIndex({'id': 1}, {unique:true});

                db.createCollection('events_fights', function(err, events_fights_collection) {
                    if (err) {
                        console.log("error creating events_fights collection: " + err);
                        return false;
                    }

                    initCrawler(fighters_collection, events_collection, events_fights_collection);
                });
            });
        });
    });
});


function getIdFromUrl(url, log_collection) {
    var id = /-([0-9]+)$/.exec(url);
    if (id[1]) {
        return id[1];
    }
    else {
        log_collection.insert({
            msg  : "не определил id: " + url,
            date : new Date().getTime()
        });
        return false;
    }
}


function initCrawler(fighters_collection, events_collection, events_fights_collection) {
    var c = new Crawler({
        "maxConnections" : 10,
        "callback"       : function(error,result,$) {
            if (error) {
                console.log("ERROR: " + error);
            }

            $("a[href^='http://www.sherdog.com/fighter/'], a[href^='/fighter/']").each(function() {
                var href = $(this).attr('href');
                if (href.slice(0, 4) != 'http')  {
                    href = "http://www.sherdog.com" + href;
                }

                if (!pages[href]) {
                    c.queue(href);

                    pages[href] = new Date().getTime();
                    console.log(href);

                    if ($('.module.bio_fighter.vcard').length > 0) {
                        var fights = $('div.left_side>.bio_graph>.graph_tag');

                        var fighter_id = getIdFromUrl($('meta[property="og:url"]').attr('content'));
                        if (!fighter_id) {
                            return false;
                        }


                        fighters_collection.findOne({'id' : fighter_id}, function (err, item) {
                            var attributes = {
                                'id'               : fighter_id,
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
                                var now_time  = new Date().getTime();
                                var diff_time = now_time - item.date_update;
                                var interval  = 1000 * 60 * 60 * 3; //Обновляем только 3 часа спустя

                                if (diff_time >= interval) {
                                    fighters_collection.update({_id : item._id}, attributes);
                                    console.log('updated');
                                }
                                else {
                                    console.log('update canceled: too early');
                                }
                            }
                            else  {
                                fighters_collection.insert(attributes);
                            }

                            var fights_rows = $('div.content.table table tr.odd, div.content.table table tr.event');
                            fights_rows.each(function() {
                                var opponent_id = getIdFromUrl($(this).find('td:eq(1)>a').attr('href'));
                                var event_id    = getIdFromUrl($(this).find('td:eq(2)>a').attr('href'));

                                if (!opponent_id || !event_id) {
                                    return false;
                                }

                                var result      = $(this).find('td:eq(0)>span').html();
                                var event_name  = $(this).find('td:eq(2)>a').text();
                                var event_date  = $(this).find('td:eq(2) .sub_line').text();
                                var referee     = $(this).find('td:eq(3) .sub_line').text();
                                var method      = $(this).find('td:eq(3)').text().replace(referee, '');
                                var round       = $(this).find('td:eq(4)').html();
                                var time        = $(this).find('td:eq(5)').html();

                                if (event_name.length == 0) {
                                    console.log("fuck" + event_id);
                                    return false;
                                }

                                events_collection.findOne({'id' : event_id}, function (err, item) {
                                    if (err) {
                                        console.log('error findOne event: ' + err);
                                        return false;
                                    }

                                    if (!item) {
                                        events_collection.insert({
                                            id : event_id,
                                            name : event_name,
                                            date : event_date,
                                            href : href
                                        });

                                        console.log("event added: " + event_name);
                                    }

                                    var criteria = { $or: [
                                        {fighter_a_id : fighter_id, fighter_b_id  : opponent_id, event_id : event_id},
                                        {fighter_a_id : opponent_id, fighter_b_id : fighter_id, event_id : event_id}
                                    ]};

                                    events_fights_collection.findOne(criteria, function(err, event_fight) {
                                        if (!event_fight) {
                                            events_fights_collection.insert({
                                                event_id      : event_id,
                                                fighter_a_id  : fighter_id,
                                                fighter_b_id  : opponent_id,
                                                referee       : referee,
                                                method        : method,
                                                round         : round,
                                                time          : time
                                            });

                                            console.log('Event fight added');
                                        }
                                        else {
                                            console.log("Event fight exists");
                                        }
                                    });
                                });
                            });
                        });

                    }
                }
            });
        }
    });

    c.queue("http://www.sherdog.com");
    //c.queue("http://www.sherdog.com/fighter/Jake-Ellenberger-13068");
}


