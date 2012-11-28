<?php
class Translator extends CApplicationComponent
{
    public $api;

    public function detectLang($str)
    {
        $en_count = substr_count($str, 'a'); //en
        $ru_count = substr_count($str, 'а'); //ru
        return $en_count > $ru_count ? 'en' : 'ru';
    }

    public function toRu($str)
    {
        return $this->detectLang($str) == 'ru' ? $str : $this->translate($str, 'en', 'ru');
    }

    public function toEn($str)
    {
        return $this->detectLang($str) == 'en' ? $str : $this->translate($str, 'ru', 'en');
    }

    public function translate($str, $from, $to)
    {
        return Yii::createComponent($this->api)->translate($str, $from, $to);
    }
}