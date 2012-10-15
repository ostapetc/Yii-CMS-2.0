<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 01.10.12
 * Time: 21:32
 * To change this template use File | Settings | File Templates.
 */
class ParseFightersCommand extends CConsoleCommand
{
    public function run()
    {
        $this->log('Начинаем парсить бойцов');

        $letters = range('a', 'z');

        $cache = Yii::app()->cache->get('last_fighter_parse');
        if ($cache)
        {
            $c   = file_get_contents($this->getUrlByLetterAndPage($cache['letter'], $cache['page']));
            $doc = new DOMDocument();
            @$doc->loadHTML($c);

            $xpath = new DOMXPath($doc);
            $next  = $xpath->query('//span[@class="pagination"]//a[contains(text(), "Next")]')->item(0);

            if ($next)
            {
                preg_match('|SearchTxt=([a-z])&page=([0-9]+)|', $next->getAttribute('href'), $data);
                $letter = $data[1];
                $page   = $data[2];
            }
            else
            {
                $key = array_search($cache['letter'], $letters);
                if (array_key_exists(++$key, $letters))
                {
                    $letter = $letters[$key];
                    $page   = 1;
                }
                else
                {
                    $letter = 'a';
                    $page   = 1;
                }
            }
        }
        else
        {
            $letter = 'a';
            $page   = '1';
        }

        Yii::app()->cache->set('last_fighter_parse', array(
            'letter' => $letter,
            'page'   => $page
        ));

        $this->log("Парсим буква ({$letter}) страница ({$page})");

        $c   = file_get_contents($this->getUrlByLetterAndPage($letter, $page));
        $doc = new DOMDocument();
        @$doc->loadHTML($c);

        $xpath = new DOMXPath($doc);
        $links = $xpath->query('//a[contains(@href, "/fighter/")]');

        $this->log("Найдено страниц: " . count($links));

        foreach ($links as $link)
        {
            $href = $link->getAttribute('href');
            if (mb_substr($href, 0, 4, 'utf-8') != 'http')
            {
                $href = 'http://www.sherdog.com' . $href;
                $source_url = $href;
            }
            else
            {
                $source_url = str_replace('http://www.sherdog.com', '', $href);
            }

            //$href = 'http://www.sherdog.com/fighter/Fedor-Emelianenko-1500';

            $c   = file_get_contents($href);
            $doc = new DOMDocument();
            @$doc->loadHTML($c);

            $xpath = new DOMXPath($doc);

            $name = $this->xpathQuery($xpath, '//span[@class="fn"]');
            if (!$name)
            {
                $this->log('Не найдено имя бойца. url: ' . $href, CLogger::LEVEL_WARNING);
                continue;
            }

            $nickname = $this->xpathQuery($xpath, '//span[@class="nickname"]');
            if ($nickname)
            {
                $nickname = trim(str_replace('"', '', $nickname));
            }

            $birthday    = $this->xpathQuery($xpath, '//span[@itemprop="birthDate"]');
            $country     = $this->xpathQuery($xpath, '//strong[@itemprop="nationality"]');
            $association = $this->xpathQuery($xpath, '//span[@itemprop="name"]');

            $height = $this->xpathQuery($xpath, '//span[@class="item height"]');
            if ($height)
            {
                preg_match('/([0-9\.]+) cm/', $height, $height);
                $height = $height[1];
            }

            $weight = $this->xpathQuery($xpath, '//span[@class="item weight"]');
            if ($weight)
            {
                preg_match('/([0-9\.]+) kg/', $weight, $weight);
                $weight = $weight[1];
            }

            $image = $xpath->query('//img[@itemprop="image"]')->item(0);
            if ($image)
            {
                $src   = $image->getAttribute('src');
                $image = pathinfo($src, PATHINFO_BASENAME);
                $path  = Fighter::getPhotosDir() . $image;

                if (!file_exists($path))
                {
                    if (file_put_contents($path, file_get_contents($src)))
                    {
                        chmod($path, 0777);
                    }
                    else
                    {
                        $image = null;
                        $this->log("Не могу сохранить фото бойца");
                    }
                }
            }

            $fighter = Fighter::model()->findByAttributes(array('source_url' => $source_url));
            if (!$fighter)
            {
                $fighter = new Fighter();
                $fighter->source_name = 'sherdog.com';
                $fighter->source_url  = $source_url;
                $fighter->source_path = $letter . $page;

                $this->log("Добавление нового бойца");
            }
            else
            {
                $this->log("Обновляем бойца " . $fighter->id);
            }

            $fighter->name        = $name;
            $fighter->nickname    = $nickname;
            $fighter->birthday    = $birthday;
            $fighter->country     = $country;
            $fighter->association = $association;
            $fighter->height      = $height;
            $fighter->weight      = $weight;
            $fighter->image       = $image;

            if ($fighter->save())
            {
                $this->log("Боец сохранен ID: " . $fighter->id);
            }
            else
            {
                $this->log("Ошибка сохранения бойца: " . print_r($fighter->errors_flat_array, 1));
            }
        }
    }


    private function log($msg, $level = CLogger::LEVEL_INFO)
    {
        Yii::log($msg, $level, 'modules.martialArts.fightersParsing');
    }


    private function getUrlByLetterAndPage($letter, $page)
    {
        return "http://www.sherdog.com/stats/fightfinder?association=&weight=&SearchTxt={$letter}&page={$page}";
    }


    private function xpathQuery(DOMXPath $xpath, $query)
    {
        $node = $xpath->query($query)->item(0);
        if ($node)
        {
            return trim($node->nodeValue);
        }
    }
}
