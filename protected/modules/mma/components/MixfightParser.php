<?php

class MixfightParser extends OsParser
{
    public function getSource()
    {
        return 'mixfight.ru';
    }


    public function getWebUrl()
    {
        return 'http://mixfight.ru/';
    }


    public function getAuthorId()
    {
        return 555;
    }


    public function parsePosts()
    {
        $content = $this->getContent($this->web_url);
        if (!$content)
        {
            return;
        }

        $doc = new DOMDocument();
        @$doc->loadHTML($content);

        $path = new DOMXPath($doc);

        $links = $path->query('//div[@class="newsItem"]/h2/a');
        $images = $path->query('//div[@class="newsItem"]/a/img');

        foreach ($links as $i => $link)
        {
            $href = $source_url = $this->prepareHref($link->getAttribute('href'));

            $page = Page::model()->findByAttributes(array(
                'source'     => $this->source,
                'source_url' => $source_url
            ));

            if ($page)
            {
                $this->log("Пост #{$page->id} уже был спарсен, пропускаем");
                continue;
            }

            $image = $images->item($i);
            if ($image)
            {
                $image = $this->web_url . $image->getAttribute('src');
            }

            $this->parseAndSavePost($this->web_url . $href, $image, $source_url);
        }
    }


    public function parseAndSavePost($url, $image, $source_url)
    {
        $months = array(
            'января',
            'февраля',
            'марта',
            'апреля',
            'мая',
            'июня',
            'июля',
            'августа',
            'сентября',
            'октября',
            'ноября',
            'декабря',
        );

        $content = $this->getContent($url);
        if (!$content)
        {
            return;
        }

        $doc = new DOMDocument();
        @$doc->loadHTML($content);

        $xpath = new DOMXPath($doc);
        $title = $xpath->query('//h1')->item(0)->textContent;

        $text = $doc->saveXML($xpath->query('//div[@id="textBlock"]')->item(0));
        $text = array_shift(explode('<div class="socialButtons">', $text));
        $text = preg_replace('|<p class="pubDate">(.*?)</p>|', '', $text);
        $text = $this->stripTags($text, '<strong><b><p><br><object><param><embed><img>');

        $date = $xpath->query('//p[@class="pubDate"]')->item(0)->nodeValue;
        $date = str_replace(array("\n", "\r", "\t"), null, $date);

        preg_match('|([0-9]{2})(.*)([0-9]{4})|', $date, $date);
        if (count($date) != 4)
        {
            $this->log('Хуета с парсингом даты, пропускаем.' . $url, CLogger::LEVEL_ERROR);
            return;
        }

        $date[2] = trim($date[2]);
        if (!in_array($date[2], $months))
        {
            v(preg_replace('/\s+/', '', $date[2]));
            v($months);
            die;
            $this->log('Нихуя не определен месяц: ' .$date[2] . '. ' . $url, CLogger::LEVEL_ERROR);
            return;
        }
        die('ee');
        $date = $date[3] . '-' . $months[$date[3]] . '-' . $date[1];
        echo $date;
        die;

        $page = new Page();                //
        $page->source     = $this->source;
        $page->source_url = $source_url;
        $page->user_id    = $this->author_id;
        $page->title      = $title;
        $page->text       = $text;
        $page->image      = $image;
        $page->status     = Page::STATUS_PUBLISHED;
        $page->type       = Page::TYPE_POST;

        $this->saveModel($page);
    }
}
