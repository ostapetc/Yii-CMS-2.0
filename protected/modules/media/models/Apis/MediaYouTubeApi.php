<?php
Yii::import('application.libs.*');
require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata_YouTube');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_AuthSub');
Zend_Loader::loadClass('Zend_Gdata_YouTube_VideoQuery');

class MediaYouTubeApi extends MediaApiAbstract
{
    protected $api;

    public $title;
    public $img;
    public $size;
    public $player_url;
    public $view_count;
    public $raters;
    public $average;
    public $id;

    public $author_name;
    public $author_uri;
    public $category;


    /**
     * @return Zend_Gdata_YouTube
     */
    public function getApi()
    {
        if (!$this->api)
        {
            $conf       = Yii::app()->params['youtube'];
            $httpClient = Zend_Gdata_ClientLogin::getHttpClient($conf['user'], $conf['pass'], 'youtube');
            $this->api  = new Zend_Gdata_YouTube($httpClient, $conf['app'], $conf['user'], $conf['key']);
        }
        return $this->api;
    }


    /**
     * @param YouTubeApiCriteria $criteria
     *
     * @return array
     */
    public function findAll($criteria)
    {
        $this->beforeFind();
        $query = new Zend_Gdata_YouTube_VideoQuery();
        $query->setVideoQuery($criteria->select);
        $query->setMaxResults($criteria->limit);
        $query->setStartIndex($criteria->offset);
        $query->setOrderBy($criteria->order);
        $query->setAuthor($criteria->author);
        $query->setCategory($criteria->category);

        $feed = $this->getApi()->getVideoFeed($query);
        return $this->populateRecords($feed, true);
    }


    /**
     * @param $entry Zend_Gdata_YouTube_VideoEntry
     */
    protected function _populate($entry)
    {
        $this->id         = $entry->getVideoId();
        $this->title      = $entry->getVideoTitle();
        $rating           = $entry->getVideoRatingInfo();
        $this->average    = $rating['average'];
        $this->raters     = $rating['numRaters'];
        $this->view_count = $entry->getStatistics()->getViewCount();
        $this->player_url = $entry->getFlashPlayerUrl();
        /** @var $author Zend_Gdata_App_Extension_Author */
        $author            = reset($entry->getAuthor());
        $this->author_name = $author->getName()->getText();
        $this->author_uri  = "http://www.youtube.com/user/" . $this->author_name;

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


    public function search()
    {
        $criteria = new YouTubeApiCriteria(array(
            'select'   => $this->title,
            'category' => $this->category,
            'author'   => $this->author,
        ));

        $dp = new YouTubeDataProvider(new MediaYouTubeApi(), array(
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
            'id',
            'author_name',
            'author_uri',
        );
    }


    public function getPrimaryKey()
    {
        return $this->id;
    }


    public function findByPk($pk)
    {
        $this->beforeFind();
        $entry = $this->getApi()->getVideoEntry($pk);
        return $this->populateRecord($entry);
    }
}