<?php
class VideoPlayer extends Widget {

    public $src;
    public $title;

    public $size = [
        'width'  => 670,
        'height' => 360
    ];

    public function init()
    {
        parent::init();
        $this->registerScripts();
    }


    public function registerScripts()
    {
        $assets = $this->assets . '/plugins/jplayer/';
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile($assets . '/jquery.jplayer.min.js');
        $cs->registerCssFile($assets . '/css/jplayer.pink.flag.css');

    }


    public function run()
    {
        $this->render('videoPlayer');
    }
}