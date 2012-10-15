<?php
abstract class ContentParserAbstract extends CComponent
{
    public function init()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(0);
    }


    abstract public function parse();


    function multipleThreadsRequest($urls)
    {
        $mh         = curl_multi_init();
        $curl_array = array();
        foreach ($urls as $i => $url)
        {
            $curl_array[$i] = curl_init($url);
            curl_setopt_array($curl_array[$i], array(
                CURLOPT_HEADER => false,
                CURLOPT_POST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_RETURNTRANSFER => true,
            ));
            curl_multi_add_handle($mh, $curl_array[$i]);
        }
        $running = NULL;
        do
        {
            usleep(1000);
            curl_multi_exec($mh, $running);
        } while ($running > 0);

        $res = array();
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
