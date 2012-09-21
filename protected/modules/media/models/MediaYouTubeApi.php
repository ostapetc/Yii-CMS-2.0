<?php
class MediaYouTubeApi extends MediaApiModel
{
    const ORDER_VIEW_COUNT = 'viewCount';
    const ORDER_LIKE_COUNT = 'likeCount';
    const ORDER_DISLIKE_COUNT = 'dislikeCount';
    const ORDER_FAVORITE_COUNT = 'favoriteCount';
    const ORDER_COMMENT_COUNT = 'commentCount';

    protected $command;
    protected $dbCriteria;
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
    public $categories = array();

    /**
     * @return Zend_Gdata_YouTube
     */
    public function getApi()
    {
        if (!$this->api) {
            Yii::import('application.libs.*');
            require_once 'Zend/Loader.php';
            Zend_Loader::loadClass('Zend_Gdata_YouTube');
            Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
            Zend_Loader::loadClass('Zend_Gdata_AuthSub');
            Zend_Loader::loadClass('Zend_Gdata_YouTube_VideoQuery');

            $conf       = Yii::app()->params['youtube'];
            $httpClient = Zend_Gdata_ClientLogin::getHttpClient($conf['user'], $conf['pass'], 'youtube');
            $this->api = new Zend_Gdata_YouTube($httpClient, $conf['app'], $conf['user'], $conf['key']);
        }
        return $this->api;
    }

    public function getDbCriteria()
    {
        return $this->dbCriteria;
    }

    public function setDbCriteria($criteria)
    {
        $this->dbCriteria = $criteria;
    }

    public function findAll(CDbCriteria $criteria)
    {
        $api = $this->getApi();
        $query = new Zend_Gdata_YouTube_VideoQuery();
        $query->setVideoQuery($criteria->select);
        $query->maxResults = $criteria->limit;
        $query->startIndex = $criteria->offset;

        $query->orderBy = 'viewCount';
        $feed = $api->getVideoFeed($query);
        return $this->populateAll($feed);
    }

    public function populateAll($feed)
    {
        $result = array();
        foreach ($feed as $entry)
        {
            $model = new static;
            $this->populate($model, $entry);
            $result[] = $model;
        }
        return $result;
    }

    public function populate($model, Zend_Gdata_YouTube_VideoEntry $entry)
    {
        $model->id = $entry->getVideoId();
        $model->title = $entry->getVideoTitle();
        $rating = $entry->getVideoRatingInfo();
        $model->average = $rating['average'];
        $model->raters = $rating['numRaters'];
        $model->view_count = $entry->getStatistics()->getViewCount();
        $model->player_url = $entry->getFlashPlayerUrl();
        /** @var $author Zend_Gdata_App_Extension_Author */
        $author = reset($entry->getAuthor());
        $model->author_name = $author->getName()->getText();
        $model->author_uri = "http://www.youtube.com/user/" . $model->author_name;

        /** @var $cat Zend_Gdata_App_Extension_Category */
        foreach ($entry->getCategory() as $cat)
        {
            if ($cat->getLabel())
            {
                $model->categories[] = $cat->getLabel();
            }
        }
        return $model;
    }
    /**
     * TODO: how it implementing???
     *
     * @param CDbCriteria $criteria
     * @return int
     */
    public function count(CDbCriteria $criteria)
    {
        return 10000;
    }

    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->select = $this->title;
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
        $entry = $this->getApi()->getVideoEntry($pk);
        $model = new static;
        return $this->populate($model, $entry);
    }
}