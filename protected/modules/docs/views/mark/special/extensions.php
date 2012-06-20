#Feed

###RSS 1.0

~~~
[php]
Yii::import('ext.feed.*');
 
// specify feed type
$feed = new EFeed(EFeed::RSS1);
$feed->title = 'Testing the RSS 1 EFeed class';
$feed->link = 'http://www.ramirezcobos.com';
$feed->description = 'This is test of creating a RSS 1.0 feed by Universal Feed Writer';
$feed->RSS1ChannelAbout = 'http://www.ramirezcobos.com/about';
// create our item  
$item = $feed->createNewItem();
$item->title = 'The first feed';
$item->link = 'http://www.yiiframework.com';
$item->date = time();
$item->description = 'Amaz-ii-ng <b>Yii Framework</b>';
$item->addTag('dc:subject', 'Subject Testing');
 
$feed->addItem($item);
 
$feed->generateFeed();
~~~

###RSS 2.0

~~~
[php]


Yii::import('ext.feed.*');
// RSS 2.0 is the default type
$feed = new EFeed();
 
$feed->title= 'Testing RSS 2.0 EFeed class';
$feed->description = 'This is test of creating a RSS 2.0 Feed';
 
$feed->setImage('Testing RSS 2.0 EFeed class','http://www.ramirezcobos.com/rss',
'http://www.yiiframework.com/forum/uploads/profile/photo-7106.jpg');
 
$feed->addChannelTag('language', 'en-us');
$feed->addChannelTag('pubDate', date(DATE_RSS, time()));
$feed->addChannelTag('link', 'http://www.ramirezcobos.com/rss' );
 
// * self reference
$feed->addChannelTag('atom:link','http://www.ramirezcobos.com/rss/');
 
$item = $feed->createNewItem();
 
$item->title = "first Feed";
$item->link = "http://www.yahoo.com";
$item->date = time();
$item->description = 'This is test of adding CDATA Encoded description <b>EFeed Extension</b>';
// this is just a test!!
$item->setEncloser('http://www.tester.com', '1283629', 'audio/mpeg');
 
$item->addTag('author', 'thisisnot@myemail.com (Antonio Ramirez)');
$item->addTag('guid', 'http://www.ramirezcobos.com/',array('isPermaLink'=>'true'));
 
$feed->addItem($item);
 
$feed->generateFeed();
Yii::app()->end();
~~~

###ATOM 1.0

~~~
[php]
Yii::import('ext.feed.*');

$feed = new EFeed(EFeed::ATOM);
 
// IMPORTANT : No need to add id for feed or channel. It will be automatically created from link.
$feed->title = 'Testing the ATOM RSS EFeed class';
$feed->link = 'http://www.ramirezcobos.com';
 
$feed->addChannelTag('updated', date(DATE_ATOM, time()));
$feed->addChannelTag('author', array('name'=>'Antonio Ramirez Cobos'));
 
$item = $feed->createNewItem();
 
$item->title = 'The first Feed';
$item->link  = 'http://www.ramirezcobos.com';
// we can also insert well formatted date strings
$item->date ='2010/24/12';
$item->description = 'Test of CDATA Encoded description <b>EFeed Extension</b>';
 
$feed->addItem($item);
 
$feed->generateFeed();
~~~






















----------------------------------------------------
----------------------------------------------------




EFlowPlayer
===========
Yii extension for the flowplayer plugin.

###Description
This is an alpha version of the extension.
It supports only the basic configuration.

###Use
Here are some examples on how to use this extension.

####Minimal
The most minimal code to get a video.Example:

~~~
[php]
$this->widget('ext.EFlowPlayer.EFlowPlayer', array(
    'flv'=>"http://pseudo01.hddn.com/vod/demo.flowplayervod/flowplayer-700.flv",
 ));
~~~

####With style and id
If we want to set some html options to the video container.Example:

~~~
[php]
$this->widget('ext.EFlowPlayer.EFlowPlayer', array(
     'flv'=>"http://pseudo01.hddn.com/vod/demo.flowplayervod/flowplayer-700.flv",
     'htmlOptions'=>array(
         'id'=>'testingplayer',
         'style'=>'width: 320px; height: 160px;',
     ),
));
~~~

####I need more videos
#####Asceding style
If we want to set some html options to the video container.Example:

~~~
[php]
$this->widget('ext.EFlowPlayer.EFlowPlayer', array(
     'flv'=>array(
         'http://ringtales.s3.amazonaws.com/d182.flv',
         'http://ringtales.s3.amazonaws.com/d181.flv',
         'http://ringtales.s3.amazonaws.com/d180.flv',
      ),
     'htmlOptions'=>array(
         'id'=>'video-',
         'style'=>'width: 320px; height: 160px;',
     ),
));
~~~

Result of this code will be 3 containers with id `video-` + key of the video url position in the array, like:
- container with id `'video-0'` points to `d182.flv`
- container with id `'video-1'` points to `d181.flv`
- container with id `'video-2'` points to `d180.flv`

#####Associative array
If we want to set some html options to the video container.Example:

~~~
[php]
$this->widget('ext.EFlowPlayer.EFlowPlayer', array(
     'flv'=>array(
         'd180'=>'http://ringtales.s3.amazonaws.com/d180.flv',
         'd181'=>'http://ringtales.s3.amazonaws.com/d181.flv',
         'd182'=>'http://ringtales.s3.amazonaws.com/d182.flv',
     ),
     'htmlOptions'=>array(
         'id'=>'testingplayer',
         'style'=>'width: 320px; height: 160px;',
     ),
 ));
~~~

#####Mixed
This is a way to use associative array and asceding style.
Although i think of something dangarous and akwark there still a
posibility. Example:

~~~
[php]
$this->widget('ext.EFlowPlayer.EFlowPlayer', array(
     'flv'=>array(
         'http://ringtales.s3.amazonaws.com/d180.flv',
         'http://ringtales.s3.amazonaws.com/d181.flv',
         'd180'=>'http://ringtales.s3.amazonaws.com/d180.flv',
         'd181'=>'http://ringtales.s3.amazonaws.com/d181.flv',
     ),
     'htmlOptions'=>array(
         'id'=>'testingplayer',
         'style'=>'width: 320px; height: 160px;',
     ),
));
~~~

###Details
- Version 0.3 alpha
- Dimitrios Mengidis

###Support
- Yii 1.1.x
- flowplayer 3.2.6

###Resources
- [Yii extension site](http://www.yiiframework.com/extension/eflowplayer/)
- [flowplayer](http://www.flowplayer.org)
- [Repository](http://www.github.com/dmtrs/EFlowPlayer)
- [while(true)](http://dmtrs.devio.us/blog)

__(This base code was generated with the [gii-extension-generator](http://www.yiiframework.com/extension/gii-extension-generator/))__
