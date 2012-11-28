<?php
class CurlHelper
{
    public static $headers = [
        'User-Agent' => "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0; .NET CLR 2.0.50727)",
        'Accept' => "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
        'Accept-Language' => "ru,en-us;q=0.7,en;q=0.3",
        'Accept-Encoding' => "gzip,deflate",
        'Accept-Charset' => "windows-1251,utf-8;q=0.7,*;q=0.7",
        'Keep-Alive' => '300',
        'Connection' => 'keep-alive',
    ];


    public static function multi($urls)
    {
        $mh         = curl_multi_init();
        $curl_array = [];
        foreach ($urls as $i => $url)
        {
            $curl_array[$i] = curl_init($url);
            curl_setopt_array($curl_array[$i], [
                CURLOPT_HTTPHEADER => self::$headers,
                CURLOPT_HEADER => false,
                CURLOPT_POST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_RETURNTRANSFER => true,
            ]);
            curl_multi_add_handle($mh, $curl_array[$i]);
        }
        $running = NULL;
        do
        {
            usleep(1000);
            curl_multi_exec($mh, $running);
        } while ($running > 0);

        $res = [];
        foreach ($urls as $i => $url)
        {
            $res[$url] = curl_multi_getcontent($curl_array[$i]);
        }

        foreach ($urls as $i => $url)
        {
            curl_multi_remove_handle($mh, $curl_array[$i]);
        }
        curl_multi_close($mh);
        return $res;
    }
}