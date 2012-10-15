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

        $links  = $path->query('//div[@class="newsItem"]/h2/a');
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

            $content = $this->getContent($this->web_url . $href);
            if (!$content)
            {
                continue;
            }

            $doc = new DOMDocument();
            @$doc->loadHTML($content);

            $path  = new DOMXPath($doc);
            $title = $path->query('//h1')->item(0)->textContent;

            $text = $doc->saveXML($path->query('//div[@id="textBlock"]')->item(0));
            $text = array_shift(explode('<div class="socialButtons">', $text));
            $text = preg_replace('|<p class="pubDate">(.*?)</p>|', '', $text);
            $text = $this->stripTags($text, '<strong><b><p><br><object><param><embed><img>');


//            if (mb_strpos($text, '404') !== false) {
//                echo $this->web_url . $href . "<br/>";
//                echo $text;
//                die;
//            }
            $page = new Page();
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
}
