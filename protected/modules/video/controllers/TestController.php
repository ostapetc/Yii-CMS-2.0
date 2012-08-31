<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 24.06.12
 * Time: 20:44
 * To change this template use File | Settings | File Templates.
 */
class TestController extends CController
{
    const API_ID = '3010254';
    const SECRET = 'DmmFc19UQlwX3HsFsXh0';

    const FORMAT_JSON = 'JSON';
    const FORMAT_XML  = 'XML';
    const FORMAT_PHP  = 'PHP';

    /**
     * @var string JSON, XML, PHP
     */
    public static $return_format = 'PHP';


    public function actionTest()
    {
        p(self::api('docs.get'));
    }


    protected static function getRequestUrl($method, $format = null)
    {
        if (!$format)
        {
            $format = self::$return_format;
        }

        if ($format == self::FORMAT_PHP)
        {
            $format = self::FORMAT_JSON;
        }

        $sig = md5('api_id=' . self::API_ID . 'format=' . $format . 'method=' . $method . 'v=3.0' . self::SECRET);
        $url = 'http://api.vk.com/api.php?api_id=' . self::API_ID. '&format=' . $format . '&method=' . $method . '&v=3.0&sig=' . $sig;
        //echo $url; die;
        return $url;
    }


    public static function api($method, $format = null)
    {
        if (!$format)
        {
            $format = self::$return_format;
        }

        $response = file_get_contents( self::getRequestUrl($method, $format));

        if ($format == self::FORMAT_PHP)
        {
            $response = json_decode($response, true);
        }

        return $response;
    }
}
