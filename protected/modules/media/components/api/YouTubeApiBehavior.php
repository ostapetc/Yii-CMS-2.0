<?php
Yii::import('media.components.api.ApiBehaviorAbstract');
Yii::import('application.libs.*');
require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata_YouTube');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_AuthSub');
Zend_Loader::loadClass('Zend_Gdata_YouTube_VideoQuery');


/**
 * @method YouTubeApi getApiModel
 */
class YouTubeApiBehavior extends ApiBehaviorAbstract
{
    public $icon;
    public $href;
    protected $api;

    public static function basePath()
    {
        return Yii::getPathOfAlias('webroot') . '/' . self::UPLOAD_PATH . '/';
    }

    public function getThumb($hq = true)
    {
        return 'http://i4.ytimg.com/vi/' . $this->pk . '/' . ($hq ? 'hq' : '') . 'default.jpg';
    }

    public function getType()
    {
        return MediaFile::TYPE_VIDEO;
    }

    public function getServerDir()
    {
        throw new CException('not implemented yet');
    }


    public function parse($source)
    {
        preg_match_all('/(youtu.be\/|\/watch\?v=|\/embed\/)([a-z0-9\-_]+)/i', $source, $matches);
        if (isset($matches[2]))
        {
            foreach ($matches[2] as $id)
            {
                return $id;
            }
        }
        return false;
    }

    public function getHref()
    {
        return $this->href;
    }

    /**
     * @return Zend_Gdata_YouTube
     */
    public function getApi()
    {
        if (!$this->api)
        {
            $conf = Yii::app()->params['youTube'];
            if (!$conf)
            {
                throw new CException('Pleas add configuration for youtube api, see comments for YouTubeApi');
            }
            $httpClient = Zend_Gdata_ClientLogin::getHttpClient($conf['user'], $conf['pass'], 'youtube');
            $this->api  = new Zend_Gdata_YouTube($httpClient, $conf['app'], $conf['user'], $conf['key']);
        }
        return $this->api;
    }

    /**
     * @param LocalApi $local_api
     */
    public function convertFromLocal($local_api)
    {
        throw new CException('not implemented yet');
    }

    public function getPlayer($size = ['width' => 128, 'height' => 128])
    {
        $conf = $this->getPreviewArray('iframe');
        return CHtml::tag('iframe', CMap::mergeArray($size, [
            'src' => $conf['val']
        ]));
    }

    public function getPlayerUrl()
    {
        $entry = $this->getApi()->getVideoEntry($this->getOwner()->remote_id);
        return $entry->getFlashPlayerUrl();
    }

    public function getPreviewArray($type = 'img')
    {
        if ($type == 'iframe')
        {
            return ['type' => 'iframe', 'val' => $this->getPlayerUrl()];
        }
        elseif ($type == 'img')
        {
            return ['type' => 'img', 'val' => $this->getThumb()];
        }
    }

    public function getPreview($size = ['width' => 128, 'height' => 128])
    {
        $conf = $this->getPreviewArray();
        return CHtml::image($conf['val'], '', []);
    }

    public function getUrl()
    {
        throw new CException('not implemented yet');
    }



    public function getUploadUrl()
    {
        $conf = Yii::app()->params['youTube'];
        return "http://uploads.gdata.youtube.com/feeds/api/users/{$conf['user']}/uploads";
    }

    const UPLOAD_PATH = 'upload/media';


    public function sendFile($file)
    {
        ignore_user_abort(true);
        set_time_limit(0);

        $uploadUrl = $this->getUploadUrl();

        $entry = new Zend_Gdata_YouTube_VideoEntry();

        $source = $this->getApi()->newMediaFileSource($file);
        $source->setContentType('video/x-ms-wmv'); //make sure to set the proper content type.
        $source->setSlug($file);

        $entry->setMediaSource($source);

        $entry->setVideoTitle($this->title);
        $entry->setVideoDescription($this->description);

//        no supported yet
        $entry->setVideoCategory('Autos');
        $entry->SetVideoTags('cars, funny');

        $newEntry = $this->getApi()->insertEntry($entry, $uploadUrl, 'Zend_Gdata_YouTube_VideoEntry');

        return $this->populateRecord($newEntry);
    }

}