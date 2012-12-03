<?php

class ValetudoParser extends OsParser
{
    public function getSource()
    {
        return 'valetudo.ru';
    }


    public function getWebUrl()
    {
        return 'http://valetudo.ru/';
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
        $doc->validateOnParse = false;
        @$doc->loadHTML($content);

        $xpath  = new DOMXPath($doc);
        $links  = $xpath->query('//a[@class="contentpagetitle"]');
        $images = $xpath->query('//div[@class="contentpaneopen"]//img');

        foreach ($links as $i => $link)
        {
            $href = $source_url = $link->getAttribute('href');
            $page = Page::model()->findByAttributes(array(
                'source'    => $this->source,
                'source_url' => $source_url
            ));

            if ($page)
            {
                $this->log("Пост #{$page->id} уже был спарсен, пропускаем");
                continue;
            }

            $this->parsePost($href);
        }
    }


    public function parsePost($url)
    {
        $source_url = $url;

        if (mb_strpos($url, $this->web_url, null, 'utf-8') === false)
        {
            $url = parse_url($url , PHP_URL_PATH);
            $url = $this->web_url . $url;
        }

        $content = $this->getContent($url);

        if (!$content)
        {
            $this->log('Не могу получить контент: ' . $url, CLogger::LEVEL_ERROR);
            return;
        }

        $doc = new DOMDocument();
        @$doc->loadHTML($content);

        $xpath = new DOMXPath($doc);

        $title = trim($xpath->query('//a[@class="contentpagetitle"]')->item(0)->textContent);

        $text = $xpath->query("//div[@class='article-content']");
        $text = $doc->saveXML($text->item(0));
        $text = $this->stripTags($text);
        $text = preg_replace('|Комментарий \[[0-9]+\]|', '', $text);

        $image  = null;
        $images = $xpath->query("//div[@class='article-content']/*/img");
        if ($images->length > 0)
        {
            /**
             * @var $image DomElement
             */
            $image      = $images->item(0);
            $image_html = $doc->saveHTML($image);
            $image      = $image->getAttribute('src');

            if (mb_substr($image, 0, 4, 'utf-8') != 'http')
            {
                $image = $this->web_url . $image;
            }

            $text = str_replace($image_html, '', $text);
        }

        $page = new Page();
        $page->source     = $this->source;
        $page->source_url = $source_url;
        $page->user_id    = $this->author_id;
        $page->title      = $title;
        $page->text       = $text;
        $page->image      = $image;
        $page->status     = Page::STATUS_PUBLISHED;
        $page->type       = Page::TYPE_POST;

        return $this->saveModel($page, $this->getWebUrl());
    }


    protected function getContent($path)
    {
        $content = parent::getContent($path);
        $content = mb_convert_encoding($content, 'utf-8', mb_detect_encoding($content));
        $content = mb_convert_encoding($content, 'html-entities', 'utf-8');
        return $content;
    }
}




















