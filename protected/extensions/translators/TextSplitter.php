<?php
abstract class TextSplitter {
    /**
     * @var int - максимальное число символов для отправки переводчику
     */
    public static $symbolLimit = 2000;

    /**
     * @var string- символы, по которым текст делится на предложения
     */
    public static $sentensesDelimiter = '.';

    /**
     * @static
     * @param  $text - исходный текст для разбиения на предложения
     * @return array - массив предложений, еще не окончательный
     */
    protected static function toSentenses ($text) {
        $sentArray = explode(self::$sentensesDelimiter, $text);
        return $sentArray;
    }

    /**
     * Разделение текста на массив больших кусков
     * @param  string $text - большой текстовый фрагмент, требующий разделения на куски
     * @return  array - массив элементов, каждый из которых не превышает предельного числа символов
     */

    public static function explode ($text) {
        $sentArray = self::toSentenses($text);
        $i = 0;
        $bigPiecesArray[0] = '';
        for ($k = 0; $k < count($sentArray); $k++) {
            $bigPiecesArray[$i] .= $sentArray[$k].self::$sentensesDelimiter;
            if (strlen($bigPiecesArray[$i]) > self::$symbolLimit){
                $i++;
                $bigPiecesArray[$i] = '';
            }
        }

        return $bigPiecesArray;
    }

    /**
     * Склеивание текста
     * @param array $bigPiecesArray - массив переведенных кусков текста, в произвольном порядке,
     * но ключи должна соответствовать исходному тексту
     * @return string - "склеенный" текст
     */
    public static function implode (array $bigPiecesArray) {

        ksort($bigPiecesArray);

        return implode($bigPiecesArray);
    }

}