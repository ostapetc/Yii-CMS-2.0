<?php
/*
 * Класс для использования API переводчика от Яндекс
 * Идеален для славянских языков, в частности русский <-> украинский
 */

Yii::import('ext.translator.TextSplitter', true);
class YandexTranslate implements ITranslator {
    protected $rootURL = 'http://translate.yandex.ru/tr.json';
    protected $translatePath = '/translate';
    protected $langCodesPairsListPath = '/getLangs';

    /**
     * @var string - символ или тег конца абзаца
     * Варианты: вывод в браузер - <br />, в файл - \n, может зависеть от ОС
     */
    public $eolSymbol = '<br />';

    /**
     * @var string - разделитель языков в запросе. Пока однозначно так определено Яндексом
     */
    public $langDelimiter = '-';


    public function translate($text, $fromLang, $toLang)
    {
        $textArray = TextSplitter::explode($text);

        $urls = [];
        foreach ($textArray as $text) {
            $urls[] = $this->rootURL.$this->translatePath.'?'.http_build_query([
                'lang' => $fromLang.'-'.$toLang,
                'text' => $text,
            ]);
        }

        $translateArray = [];
        foreach(CurlHelper::multi($urls) as $rawTranslate)
        {
            $rawTranslate = trim($rawTranslate, '"');
            $translateArray[] = str_replace('\n', $this->eolSymbol, $rawTranslate);
        }

        return TextSplitter::implode($translateArray);
    }

    /**
     * @return mixed Получаем пары перевода from-to в виде 'ru-uk', 'en-fr'
     */
    public function yandexGetLangsPairs(){

        $jsonLangsPairs = $this->yandexConnect($this->langCodesPairsListPath);

        $rawOut =  json_decode($jsonLangsPairs, true);

        return $rawOut['dirs'];
    }

    /**
     * @return получаем все языки FROM
     */
    public function yandexGet_FROM_Langs(){

        $langPairs = $this->yandexGetLangsPairs();

        foreach ($langPairs as $langPair){
            $smallArray = explode($this->langDelimiter, $langPair);
            $outerArray[$smallArray[0]] = $smallArray[0];
        }
        return $outerArray;
    }

    /**
     * @return получаем все языки TO
     */
    public function yandexGet_TO_Langs(){

        $langPairs = $this->yandexGetLangsPairs();

        foreach ($langPairs as $langPair){
            $smallArray = explode($this->langDelimiter, $langPair);
            $outerArray[$smallArray[1]] = $smallArray[1];
        }
        return $outerArray;
    }

}