var pages   = {};
var Crawler = require("crawler").Crawler;
var mysql   = require('mysql');

var connection = mysql.createConnection({
    host     : 'localhost',
    user     : 'root',
    password : '1',
    database : 'cms'
});

var c = new Crawler({
    "maxConnections" : 10,
    "callback"       : parserCallback
});

connection.connect(function(err) {
    if (err) {
        console.log("DB connect error: " + err);
        die();
    }

    c.queue("http://www.sherdog.com");
});


function parserCallback(error, result, $) {
    if (error) {
        console.log("ERROR: " + error);
    }

    if ($('.module.bio_fighter.vcard').length > 0) {
        parseFighter($);
    }

    var fights_rows = $('div.content.table table tr.odd, div.content.table table tr.event');
    if (fights_rows.length) {
        parseFights($, fights_rows);
    }

    $("a[href^='http://www.sherdog.com/fighter/'], a[href^='/fighter/']").each(function () {
        var href = $(this).attr('href');
        if (href.slice(0, 4) != 'http') {
            href = "http://www.sherdog.com" + href;
        }

        if (!pages[href]) {
            c.queue(href);

            pages[href] = new Date().getTime();
            console.log(href);
        }
    });
}


function getIdFromUrl(url, log_collection) {
    var id = /-([0-9]+)$/.exec(url);
    if (id[1]) {
        return id[1];
    }
    else {
        log_collection.insert({
            msg:"не определил id: " + url,
            date:new Date().getTime()
        });
        return false;
    }
}


function die(msg) {
    if (!msg) {
        msg = "program terminated";
    }

    console.log(msg);
    process.exit(1);
}


function insertSql(table, attributes) {
    var result = "INSERT INTO " + table;
    var fields = [];
    var values = [];

    for (var field in attributes) {
        fields.push('`' + field + '`');
        values.push("'" + attributes[field] + "'");
    }

    result+= "(" + fields.join(',') + ") VALUES(" + values.join(',') + ")";
    return result;
}


function updateSql(table, attributes, condition) {
    var result = "UPDATE " + table + " SET ";
    var sets   = [];

    for (var field in attributes) {
        sets.push("`" + field + "` = '" + attributes[field] + "'");
    }

    result+= sets.join(',') + " WHERE " + condition;
    return result;
}


function parseFighter($) {
    var fights = $('div.left_side>.bio_graph>.graph_tag');

    var fighter_id = getIdFromUrl($('meta[property="og:url"]').attr('content'));
    if (!fighter_id) {
        return false;
    }

    var sql = "SELECT * FROM parser_fighters WHERE id = " + fighter_id;

    connection.query(sql, function (err, result, fields) {
        if (err) {
            console.log('error: ' + err);
            die();
        };

        var fighter = result[0];

        var attributes = {
            'id':fighter_id,
            'name':$('span.fn').html(),
            'nickname':$('span.nickname em').html(),
            'birthdate':$('span.birthday span').html(),
            'city':$('span.locality').html(),
            'height':$('span.height strong').html().replace("'", '.').replace('"', ''),
            'weight':$('span.weight strong').html().replace("lbs", ''),
            'class':$('h6.wclass strong').html(),
            'association':$('h5.association span a span').html(),
            'wins':$('div.bio_graph .counter').html(),
            'losses':$('div.bio_graph.loser .counter').html(),
            'win_ko':parseInt($(fights[0]).html()),
            'win_submissions':parseInt($(fights[1]).html()),
            'win_decisions':parseInt($(fights[2]).html()),
            'loss_ko':parseInt($(fights[3]).html()),
            'loss_submissions':parseInt($(fights[4]).html()),
            'loss_decisions':parseInt($(fights[5]).html()),
            'image':$('img.profile_image.photo').attr('src'),
            'date_update':new Date().getTime()
        }

        if (fighter) {
            var now_time  = new Date().getTime();
            var diff_time = now_time - fighter.date_update;
            var interval  = 1000 * 60 * 60 * 3; //Обновляем только 3 часа спустя

            if (diff_time >= interval) {
                var sql = updateSql('parser_fighters', attributes, 'id = ' + fighter.id);
                connection.query(sql, function (err) {
                    if (err) throw err;
                });

                console.log('updated fighter');
            }
            else {
                console.log('update fighter canceled: too early for fighter: ' + fighter.id);
            }
        }
        else {
            connection.query("INSERT INTO parser_fighters SET ?", attributes, function(err, result) {
                if (err) {
                    console.log('error inserting fighter: ' + err);
                    die();
                }
                else {
                    console.log('inserted fighter');
                }
            });
        }
    });
}


function parseFights($, fights_rows) {
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
}







