var CrawlerObject = require("crawler").Crawler,
    crawler = new CrawlerObject({
        maxConnections: 20
    }),

    fs = require('fs'),
    url = require('url'),
    http = require('http'),
    spawn = require('child_process').spawn,

    async = require('async');

var parse = function (url, callback) {
    crawler.queue([
        {
            uri: url,
            callback: callback
        }
    ]);
};

var mongo = {
    server: null,
    client: null,
    opened: false,
    getClient: function (callback) {
        var that = this;
        if (!this.server) {
            var mongodb = require('mongodb');
            that.server = new mongodb.Server("127.0.0.1", 27017, { auto_reconnect: true, w: 'majority' });
            that.client = new mongodb.Db('parsers', that.server, {safe: true});
        }

        if (this.opened) {
            that.client.open(function (err, p_client) {
                this.opened = true;
                callback(that.client);
            });
        } else {
            callback(that.client);
        }
    }
};

var parsers = {
        sherdog_video: {
            url: null,
            parser: function (error, result, $) {

            }
        },
        sherdog_gallery: {
            base_url: 'http://www.sherdog.com',
            url: "/pictures",
            parser: function (error, result, $) {
                $("div.content li h3.title a").each(function (url) {
                    var url = parsers.sherdog_gallery.base_url + $(this).attr('href'),
                        id = url.split('-').pop(),
                        title = $.trim($(this).text()),
                        counters = []; //contained count of non parsed images for each gallery

                    //main parser
                    var parse_gallery = function (collection) {
                        var gallery = {
                            title: title,
                            gallery_id: id,
                            imgs: []
                        };

                        //parser image page
                        var img_page_parser = function (error, result, $) {
                            var src = $('div.big_picture img').attr('src');
                            if (src) {
                                gallery.imgs.push({
                                    title: $.trim($('div.picture_description').text()),
                                    url: src
                                });
                            }

//                            console.log(counters[id]);

                            if (--(counters[id]) == 0) {
                                parsers.sherdog_gallery.download_files(gallery.imgs, function () {
                                    console.log(gallery);
//                                  collection.insert(gallery, console.log);
                                });
                            }
                        };

                        //parser gallery page
                        var gallery_page_parser = function (error, result, $) {
                            var img_pages = $('#photo_carousel a');
                            counters[id] = img_pages.length;

                            img_pages.each(function () {
                                var img_page = parsers.sherdog_gallery.base_url + $(this).attr('href');
                                parse(img_page, img_page_parser);
                            });
                        };

                        parse(url, function (error, result, $) {
                            var gallery_page = parsers.sherdog_gallery.base_url + $('div.content.img_list a:first').attr('href');
                            parse(gallery_page, gallery_page_parser);
                        });
                    };


                    //parser if in mongo we have no it
                    mongo.getClient(function (client) {
                        client.collection('sherdog_gallery', function (err, collection) {
                            collection.findOne({gallery_id: id}, function (err, item) {
                                if (item) {
                                    return true;
                                }

                                parse_gallery(collection);
                            });
                        });
                    });
                });
            },
            download_files: function (imgs, callback) {
                async.map(imgs, function (img) {
                    var file_name = url.parse(img.url).pathname.split('/').pop();
                    var file = fs.createWriteStream('/tmp/' + file_name);
                    var curl = spawn('curl', [img.url]);
                    curl.stdout.on('data', function (data) {
                        file.write(data);
                    });
                    curl.stdout.on('end', function (data) {
                        file.end();
                    });
                    curl.on('exit', function (code) {
                        if (code != 0) {
                            console.log('Failed: ' + code);
                        }
                    });
                }, callback);
            }
        }
    }
    ;

parse(parsers.sherdog_gallery.base_url + parsers.sherdog_gallery.url, function (error, result, $) {
    parsers.sherdog_gallery.parser(error, result, $);
});
