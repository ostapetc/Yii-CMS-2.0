<?php
Yii::import('content.commands.parsers.ContentParserAbstract', true);

class VkVideoGroupParser extends ContentParserAbstract
{
    public $base = 'http://vk.com';

    public $groups = [];

    protected $ch;


    public function parse()
    {
        $this->ch = curl_init();

        libxml_use_internal_errors(true);
        $doc = new DOMDocument();

        $response = $this->get($this->base . '/mma.news');

        $doc->loadHTML($response);
        $xpath = new DOMXPath($doc);

        foreach ($xpath->query("//div[@id='public_videos']/a") as $row)
        {
            $oid      = '-' . end(explode('-', $row->getAttribute('href')));
            $response = $this->post($this->base . '/al_video.php', [
                'act'    => 'load_videos_silent',
                'al'     => 1,
                'offset' => 0,
                'oid'    => $oid
            ]);
            $data     = CJSON::decode(substr($response, 30)); // some magic
            foreach ($data['all'] as $video)
            {
                $response = $this->post($this->base . '/al_video.php', [
                    'act' => 'video_embed_box',
                    'al' => 1,
                    'oid' => $video[0],
                    'vid' => $video[1]
                ]);
                dump($response);
                // WHAT?!?!?!?!?!?!!

//                <iframe src="http://vkontakte.ru/video_ext.php?oid=32327704&id=157733416&hash=6b422c2d7de877e0" width="607" height="360" frameborder="0"></iframe>
            }

            break;
        }


        libxml_clear_errors();
        curl_close($this->ch);
    }


    public function get($url)
    {
        curl_setopt($this->ch, CURLOPT_POST, false);
        curl_setopt($this->ch, CURLOPT_URL, $url);
        return $this->curl_redirect_exec($this->ch);
    }


    public function post($url, $params)
    {
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_URL, $url);
        return $this->curl_redirect_exec($this->ch);
    }


    public function authorize()
    {
        $cookie_file = Yii::getPathOfAlias('runtime') . '/cookie.txt';

        $need_authorize = false;
        if (is_file($cookie_file))
        {
            $stat        = stat($cookie_file);
            $create_time = $stat[9];
            if ($create_time - time() > 60 * 60 * 24 * 5)
            {
                @unlink($cookie_file);
                $need_authorize = true;
            }
        }
        else
        {
            $need_authorize = true;
        }
        if (!$need_authorize)
        {
            return true;
        }

        $user_agent = 'Mozilla/5.0 (Windows; U; Windows NT 6.0; ru; rv:1.9.2.13) ' .
            'Gecko/20101203 Firefox/3.6.13 ( .NET CLR 3.5.30729)';

        $conf = Yii::app()->params->vk;


        // чтобы сайт думал, что мы - браузер:
        curl_setopt($this->ch, CURLOPT_USERAGENT, $user_agent);

        // ответ сервера будем записывать в переменную
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);

        //curl_setopt($this->ch, CURLOPT_HEADER, 1);

        curl_setopt($this->ch, CURLOPT_REFERER, 'http://m.vk.com/login?fast=1&hash=&s=0&to=');
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($this->ch, CURLOPT_COOKIEFILE, Yii::getPathOfAlias('runtime') . '/cookie.txt');
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, Yii::getPathOfAlias('runtime') . '/cookie.txt');
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_URL,
            'https://login.vk.com/?act=login&from_host=m.vk.com&from_protocol=http&ip_h=&pda=1');


        $this->curl_redirect_exec($this->ch);

        //формируем запрос
        $post = [
            'email' => $conf['user'],
            'pass'  => $conf['pass']
        ];

        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($post));

        // собственно этот ответ сервера уже доказывает что мы авторизировались
        $this->curl_redirect_exec($this->ch);
    }


    // Функция, которая позволяет нам переходить по редиректам с включенной опцией open_basedir
    function curl_redirect_exec($ch, $redirects = 0, $curlopt_returntransfer = true, $curlopt_maxredirs = 10, $curlopt_header = false)
    {
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data                   = curl_exec($ch);
        $http_code              = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $exceeded_max_redirects = $curlopt_maxredirs > $redirects;
        $exist_more_redirects   = false;
        if ($http_code == 301 || $http_code == 302)
        {
            if ($exceeded_max_redirects)
            {
                list($header) = explode("\r\n\r\n", $data, 2);
                $matches = [];
                preg_match('/(Location:|URI:)(.*?)\n/', $header, $matches);
                $url        = trim(array_pop($matches));
                $url_parsed = parse_url($url);
                if (isset($url_parsed))
                {
                    curl_setopt($ch, CURLOPT_URL, $url);
                    $redirects++;
                    return $this->curl_redirect_exec($ch, $redirects, $curlopt_returntransfer,
                        $curlopt_maxredirs, $curlopt_header);
                }
            }
            else
            {
                $exist_more_redirects = true;
            }
        }
        if ($data !== false)
        {
            if (!$curlopt_header)
            {
                list(, $data) = explode("\r\n\r\n", $data, 2);
            }
            if ($exist_more_redirects)
            {
                return false;
            }
            if ($curlopt_returntransfer)
            {
                return $data;
            }
            else
            {
                echo $data;
                if (curl_errno($ch) === 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
        else
        {
            return false;
        }
    }
}
