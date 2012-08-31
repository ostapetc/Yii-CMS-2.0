<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 26.06.12
 * Time: 21:34
 * To change this template use File | Settings | File Templates.
 */
class YoutubeController extends CController
{
    const AUTH_URL = 'https://www.google.com/youtube/accounts/ClientLogin';
    const API_KEY  = 'AI39si4Ryb3ecJvIgLV5UUOTCilTQBrNxFjS4mnNvcrcELYIk4DxNteIcSDoBKER2txBMwQTAyttWOzTjQFOaSjXEqxUho3UuA';


    public function actionIndex()
    {
        Yii::import('application.libs.*');

        require_once 'Zend' . DS . 'Gdata' . DS . 'YouTube.php';
        require_once 'Zend' . DS . 'Gdata' . DS . 'ClientLogin.php';

        $http_client = Zend_Gdata_ClientLogin::getHttpClient(
            'yii.gdata@gmail.com',
            'yii.gdata321',
            'youtube',
             null,
            'Yii CMS',
             null,
             null,
            self::AUTH_URL
        );

        $http_client->setHeaders('X-GData-Key', "key=" . self::API_KEY);

        $youtube = new Zend_Gdata_YouTube($http_client);

        $videoFeed = $youtube->getVideoFeed(Zend_Gdata_YouTube::VIDEO_URI);
    }
}
