<?php

class TextComponent extends CApplicationComponent
{
    public static function cut($text, $length, $delim = '., -:;', $tail = "")
    {
        $text = strip_tags($text);
        if (mb_strlen($text, 'utf-8') <= $length)
        {
            return $text;
        }

        $pos = mb_strpos($text, ' ', $length, 'utf-8');

        if ($pos == false)
        {
            return $text;
        }
        return trim(mb_substr(html_entity_decode($text, ENT_NOQUOTES, 'utf-8'), 0, $pos, 'utf-8'), '., -:;') .
            $tail;
    }


    public static function toUrl($string)
    {
        $string = self::translit($string);
        return str_replace(" ", "_", $string);
    }


    public static function translit($string)
    {
        $words = array(
            "А"  => "A",
            "Б"  => "B",
            "В"  => "V",
            "Г"  => "G",
            "Д"  => "D",
            "Е"  => "E",
            "Ж"  => "J",
            "З"  => "Z",
            "И"  => "I",
            "Й"  => "Y",
            "К"  => "K",
            "Л"  => "L",
            "М"  => "M",
            "Н"  => "N",
            "О"  => "O",
            "П"  => "P",
            "Р"  => "R",
            "С"  => "S",
            "Т"  => "T",
            "У"  => "U",
            "Ф"  => "F",
            "Х"  => "H",
            "Ц"  => "TS",
            "Ч"  => "CH",
            "Ш"  => "SH",
            "Щ"  => "SCH",
            "Ъ"  => "",
            "Ы"  => "YI",
            "Ь"  => "",
            "Э"  => "E",
            "Ю"  => "YU",
            "Я"  => "YA",
            "а"  => "a",
            "б"  => "b",
            "в"  => "v",
            "г"  => "g",
            "д"  => "d",
            "е"  => "e",
            "ж"  => "j",
            "з"  => "z",
            "и"  => "i",
            "й"  => "y",
            "к"  => "k",
            "л"  => "l",
            "м"  => "m",
            "н"  => "n",
            "о"  => "o",
            "п"  => "p",
            "р"  => "r",
            "с"  => "s",
            "т"  => "t",
            "у"  => "u",
            "ф"  => "f",
            "х"  => "h",
            "ц"  => "ts",
            "ч"  => "ch",
            "ш"  => "sh",
            "щ"  => "sch",
            "ъ"  => "y",
            "ы"  => "yi",
            "ь"  => "",
            "э"  => "e",
            "ю"  => "yu",
            "я"  => "ya",
            " "  => "_",
            "."  => "",
            ","  => "",
            "?"  => "",
            "!"  => "",
            ":"  => ""
        );

        return strtr($string, $words);
    }

    function antimat($string)
    {
        //setlocale (LC_ALL, "ru_RU.UTF8");

        //latin equivalents for russian letters
        $let_matches = array(
            "a" => "а",
            "c" => "с",
            "e" => "е",
            "k" => "к",
            "m" => "м",
            "o" => "о",
            "x" => "х",
            "y" => "у",
            "ё" => "е"
        );
        $bad_words   = array(
            ".*ху(й|и|я|е|л(и|е)).*", ".*пи(з|с)д.*", "бля.*", ".*бля(д|т|ц).*", "(с|сц)ук(а|о|и).*", "еб.*",
            ".*уеб.*", "Позитивеб.*", ".*еб(а|и)(н|с|щ|ц).*", ".*ебу(ч|щ).*", ".*пид(о|е)р.*", ".*хер.*",
            "г(а|о)ндон", ".*Позитивлуп.*"
        );

        $counter     = 0;
        $elems       = explode(" ", $string); //here we explode string to words
        $count_elems = count($elems);
        for ($i = 0; $i < $count_elems; $i++)
        {
            $blocked = 0;
            /*formating word...*/
            $str_rep = eregi_replace("[^a-zA-Zа-яА-Яё]", "", strtolower($elems[$i]));
            for ($j = 0; $j < strlen($str_rep); $j++)
            {
                foreach ($let_matches as $key => $value)
                {
                    if ($str_rep[$j] == $key)
                    {
                        $str_rep[$j] = $value;
                    }
                }
            }
            /*done*/

            /*here we are trying to find bad word*/
            /*match in the special array*/
            for ($k = 0; $k < count($bad_words); $k++)
            {
                if (ereg("\*$", $bad_words[$k]))
                {
                    if (ereg("^" . $bad_words[$k], $str_rep))
                    {
                        $elems[$i] = "<font color=red>цетзура</font> "; //можно рандомные замены напихать сюда
                        $blocked   = 1;
                        $counter++;
                        break;
                    }
                }
                if ($str_rep == $bad_words[$k])
                {
                    $elems[$i] = $this->rand_replace();
                    $blocked   = 1;
                    $counter++;
                    break;
                }
            }
        }
        if ($counter != 0)
        {
            $string = implode(" ", $elems);
        } //here we implode words in the whole string
        return $string;
    }


    /**
     * Генерирует заданное колличество паракрафов с текстом.
     *
     * @param int    $count
     * @param int    $words
     * @param bool   $loremIpsumFirst
     * @param string $wrapperTag
     *
     * @return string
     */
    public function lipsumParagraphs($count = 0, $words = 0, $loremIpsumFirst = true, $wrapperTag = 'p')
    {
        $text  = '';
        $count = empty($count) ? rand(1, 10) : $count;
        for ($i = 0; $i < $count; $i++)
        {
            if (!empty($wrapperTag))
            {
                $text .= CHtml::tag($wrapperTag, array(), $this->lipsumWords($words,
                    $loremIpsumFirst && $i == 0));
            }
        }
        return $text;
    }

    /**
     * Генерирует заданное колличество слов
     *
     * @param mixed $count           the number of words.
     * @param mixed $loremIpsumFirst which start with "Lorem ipsum dolor sit amet".
     *
     * @return string
     */
    public function lipsumWords($count = 0, $loremIpsumFirst = true)
    {
        $library      = array(
            "lorem", 'ipsum', "dolor", "sit", "amet", "integer", "vut", "nunc", "risus", "a", "sagittis",
            "turpis", "nunc", "eu", "urna", "urna", "pellentesque", "porttitor", "est", "ut", "augue",
            "cursus", "scelerisque", "in", "hac", "habitasse", "platea", "dictumst", "sed", "ut", "odio", "a",
            "ultricies", "dapibus", "cum", "sociis", "natoque", "penatibus", "et", "magnis", "dis",
            "parturient", "montes", "nascetur", "ridiculus", "mus", "etiam", "vel", "lacus", "magna", "nec",
            "aliquam", "augue", "lundium", "integer", "porttitor", "porta", "in", "rhoncus", "adipiscing",
            "diam", "ultrices", "turpis", "auctor", "aenean", "pulvinar", "egestas", "ac", "placerat", "sed",
            "lectus", "mauris", "rhoncus", "mid", "tincidunt", "dignissim", "elementum", "in", "odio", "duis",
            "vel", "magna", "elit", "phasellus", "tincidunt", "nisi", "pid", "pulvinar", "placerat", "purus",
            "augue", "aliquet", "tortor", "et", "tristique", "turpis", "enim", "nec", "nisi", "proin",
            "facilisis", "adipiscing", "enim", "ac", "mattis", "arcu", "elementum", "et", "cras", "massa",
            "non", "velit", "tempor", "scelerisque", "ac", "quis", "eros",
        );
        $punctuations = array(
            '.', ',', '!',
        );

        $text             = '';
        $libraryCount     = count($library);
        $punctuationCount = count($punctuations);
        $count            = empty($count) ? rand(5, 100) : $count;
        for ($i = 0, $p = 0, $begin = true; $i < $count; $i++)
        {
            if ($loremIpsumFirst && $i < 5)
            {
                $word = $library[$i];
            }
            else
            {
                $word = $library[rand(1, $libraryCount) - 1];
            }
            $text .= $begin ? ucfirst($word) : $word;
            $punctuation = ($i - $p + 1) % rand(3, 10) == 0 && $i + 1 != $count ? $punctuations[
            rand(1, $punctuationCount) - 1] : false;
            if ($punctuation !== false)
            {
                $text .= $punctuation;
                $p = $i;
            }
            $begin = $punctuation !== false && $punctuation != ',';
            $text .= $i + 1 != $count ? ' ' : '.';
        }
        return $text;
    }
}
