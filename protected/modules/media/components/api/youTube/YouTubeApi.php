<?php
/**
 * add in configuration
 * 'params'     => array(
 *      'youTube' => array(
 *          'user' => '',
 *          'pass' => '',
 *          'app'  => '',
 *          'key'  => ''
 *      )
 * )
 *
 */

Yii::import('application.libs.*');
require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata_YouTube');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_AuthSub');
Zend_Loader::loadClass('Zend_Gdata_YouTube_VideoQuery');

class YouTubeApi extends ApiAbstract
{
    const UPLOAD_PATH = 'upload/media';

    protected $api;
    protected $criteriaClass = 'YouTubeApiCriteria';

    public $title;
    public $description;
    public $img;
    public $size;
    public $player_url;
    public $view_count;
    public $raters;
    public $average;
    public $pk;

    public $author;
    public $author_uri;
    public $category;


    public function beforeFind()
    {

        return parent::beforeFind();
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


    public function getUploadUrl()
    {
        $conf = Yii::app()->params['youTube'];
        return "http://uploads.gdata.youtube.com/feeds/api/users/{$conf['user']}/uploads";
    }


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


    public function getUploadToken($name)
    {
        $myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();
//        $myVideoEntry->setVideoTitle($this->title);
//        $myVideoEntry->setVideoDescription($this->description);
//        $myVideoEntry->setVideoCategory($this->category);
        $myVideoEntry->setVideoTitle($name);
        $myVideoEntry->setVideoDescription('d');
        $myVideoEntry->setVideoCategory('Autos');
        $myVideoEntry->SetVideoTags('cars, funny');

        return $this->getApi()
            ->getFormUploadToken($myVideoEntry, 'http://gdata.youtube.com/action/GetUploadToken');
    }


    public function save()
    {
        $videoEntry = $this->getApi()->getVideoEntry($this->pk);
        $videoEntry->setVideoDescription($this->description);
        $videoEntry->setVideoTitle($this->title);
        //maybe need real video? getEditLink is empty now
        if ($videoEntry->getEditLink())
        {
            $putUrl = $videoEntry->getEditLink()->getHref();
            $this->getApi()->updateEntry($videoEntry, $putUrl);
            return true;
        }
        return false;
    }


    public function getUrl()
    {
        throw new CException('no implemented yet');
    }


    public function getHref()
    {
        throw new CException('no implemented yet');
    }


    /**
     * @param YouTubeApiCriteria $criteria
     *
     * @return array
     */
    public function findAll($criteria)
    {
        try
        {
            $this->beforeFind();
            $this->getDbCriteria()->mergeWith($criteria);
            $cache_key = $criteria->toCacheKey();
            if (!($res = Yii::app()->cache->get($cache_key)))
            {
                $query = new Zend_Gdata_YouTube_VideoQuery();
                $query->setVideoQuery($criteria->select);
                $query->setMaxResults($criteria->limit);
                $query->setStartIndex($criteria->offset);
                $query->setOrderBy($criteria->order);
                $query->setAuthor($criteria->author);
                $query->setCategory($criteria->category);


                $feed = $this->getApi()->getVideoFeed($query);
                $res  = $this->populateRecords($feed, true);
                Yii::app()->cache->set($cache_key, $res, 600);
            }
            return (array)$res;
        } catch (Exception $e)
        {
            return array();
        }
    }


    /**
     * @param $entry Zend_Gdata_YouTube_VideoEntry
     */
    protected function _populate($entry)
    {
        $this->pk      = $entry->getVideoId();
        $this->title   = $entry->getVideoTitle();
        $rating        = $entry->getVideoRatingInfo();
        $this->average = $rating['average'];
        $this->raters  = $rating['numRaters'];
        if ($entry->getStatistics())
        {
            $this->view_count = $entry->getStatistics()->getViewCount();
        }
        $this->player_url = $entry->getFlashPlayerUrl();
        /** @var $author Zend_Gdata_App_Extension_Author */
        $author           = reset($entry->getAuthor());
        $this->author     = $author->getName()->getText();
        $this->author_uri = "http://www.youtube.com/user/" . $this->author;

        /** @var $cat Zend_Gdata_App_Extension_Category */
        foreach ($entry->getCategory() as $cat)
        {
            if ($cat->getLabel())
            {
                $this->category = $cat->getLabel();
                break;
            }
        }
    }


    public static function basePath()
    {
        return Yii::getPathOfAlias('webroot') . '/' . self::UPLOAD_PATH . '/';
    }


    /**
     * TODO: how it implementing???
     *
     * @param YouTubeApiCriteria $criteria
     *
     * @return int
     */
    public function count($criteria)
    {
        return 10000;
    }


    public function search($props = array())
    {
        $criteria = clone $this->getDbCriteria();
        $criteria->mergeWith(array(
            'select'        => $this->title,
            'category'      => $this->category,
            'author'        => $this->author,
        ));

        $criteria->mergeWith($props);
        $dp = new YouTubeApiDataProvider(new YouTubeApi(), array(
            'criteria' => $criteria
        ));
        return $dp;
    }


    public function attributeNames()
    {
        return array(
            'title',
            'img',
            'size',
            'player_url',
            'view_count',
            'raters',
            'average',
            'pk',
            'author',
            'author_uri',
        );
    }


    public function findByPk($pk)
    {
        $this->beforeFind();
        $entry = $this->getApi()->getVideoEntry($pk);
        return $this->populateRecord($entry);
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


    public function getThumb($hq = true)
    {
        return 'http://i4.ytimg.com/vi/' . $id . '/' . ($hq ? 'hq' : '') . 'default.jpg';
    }
}