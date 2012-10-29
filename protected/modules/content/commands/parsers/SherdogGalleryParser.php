<?php
Yii::import('content.commands.parsers.ContentParserAbstract', true);

class SherdogGalleryParser extends ContentParserAbstract
{
    public $next_url = '/pictures';

    public $base_url = 'http://www.sherdog.com';


    public function parse()
    {
        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        /** @var $row DOMElement */
        /** @var $attr DOMAttr */
        while ($this->next_url)
        {
            $doc->loadHTML(file_get_contents($this->base_url . $this->next_url));
            $xpath = new DOMXPath($doc);

            foreach ($xpath->query("//div[@class='content']//li/h3[@class='title']/a") as $row)
            {
                $id = end(explode('-', $row->getAttribute('href')));

                //checko on existing
                if (MediaAlbum::model()->parent('sherdog.com', $id)->find())
                {
                    return true;
                }
                $gallery = [
                    'title' => $row->textContent,
                    'id'    => $id,
                    'imgs'  => $this->parseGalleryPage($row->getAttribute('href')),
                ];
                $this->saveGallery($gallery);
            }

            $row            = $xpath->query("//div[@class='col_left']//a[@rel='next']")->item(0);
            $this->next_url = $row ? $row->getAttribute('href') : false;
        }
        libxml_clear_errors();
    }


    protected function parseGalleryPage($url)
    {
        $doc = new DOMDocument();
        $doc->loadHTML(file_get_contents($this->base_url . $url));
        $xpath = new DOMXPath($doc);

        $gallery_url = $xpath->query("//div[@class='content img_list']//a/@href")->item(0)->nodeValue;

        $doc->loadHTML(file_get_contents($this->base_url . $gallery_url));
        $xpath = new DOMXPath($doc);

        //get urls on photo page
        $urls = [];
        foreach ($xpath->query("//ul[@id='photo_carousel']//a/@href") as $attr)
        {
            $urls[] = $this->base_url . $attr->nodeValue;
        }

        $imgs = [];
        foreach ($this->multipleThreadsRequest($urls) as $url => $html)
        {
            if ($html)
            {
                $imgs[] = $this->parseImgPage($html);
            }
        }

        return $imgs;
    }


    protected function parseImgPage($html)
    {
        $doc = new DOMDocument();
        $doc->loadHTML($html);
        $xpath = new DOMXPath($doc);

        return [
            'title' => trim($xpath->query("//div[@class='picture_description']")->item(0)->textContent),
            'img'   => $xpath->query("//div[@class='big_picture']//img/@src")->item(0)->nodeValue
        ];
    }


    protected function saveGallery($gallery)
    {
        $album            = new MediaAlbum();
        $album->title     = $gallery['title'];
        $album->model_id  = 'sherdog.com';
        $album->object_id = $gallery['id'];
        $album->save(false);

        foreach ($gallery['imgs'] as $img)
        {
            $file            = new MediaFile('create', 'remote');
            $file->model_id  = get_class($album);
            $file->object_id = $album->id;
            $file->tag       = 'images';
            $file->title     = $img['title'];
            $file->remote_id = $img['img'];
            $file->save(false);
        }
    }
}
