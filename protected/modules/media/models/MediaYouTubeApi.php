<?php
class MediaYouTubeApi extends MediaApiModel
{
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
    public $category = array();


    /**
     * @return Zend_Gdata_YouTube
     */
    public function getApi()
    {
        if (!$this->api)
        {
            Yii::import('application.libs.*');
            require_once 'Zend/Loader.php';
            Zend_Loader::loadClass('Zend_Gdata_YouTube');
            Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
            Zend_Loader::loadClass('Zend_Gdata_AuthSub');
            Zend_Loader::loadClass('Zend_Gdata_YouTube_VideoQuery');

            $conf       = Yii::app()->params['youtube'];
            $httpClient = Zend_Gdata_ClientLogin::getHttpClient($conf['user'], $conf['pass'], 'youtube');
            $this->api  = new Zend_Gdata_YouTube($httpClient, $conf['app'], $conf['user'], $conf['key']);
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


    /**
     * @param YouTubeApiCriteria $criteria
     *
     * @return array
     */
    public function findAll($criteria)
    {
        $api   = $this->getApi();
        $query = new Zend_Gdata_YouTube_VideoQuery();

        $query->setVideoQuery($criteria->select);
        $query->setMaxResults($criteria->limit);
        $query->setStartIndex($criteria->offset);
        $query->setOrderBy($criteria->order);
        $query->setAuthor($criteria->author);
        $query->setCategory($criteria->category);

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
        $model->id         = $entry->getVideoId();
        $model->title      = $entry->getVideoTitle();
        $rating            = $entry->getVideoRatingInfo();
        $model->average    = $rating['average'];
        $model->raters     = $rating['numRaters'];
        $model->view_count = $entry->getStatistics()->getViewCount();
        $model->player_url = $entry->getFlashPlayerUrl();
        /** @var $author Zend_Gdata_App_Extension_Author */
        $author             = reset($entry->getAuthor());
        $model->author_name = $author->getName()->getText();
        $model->author_uri  = "http://www.youtube.com/user/" . $model->author_name;

        /** @var $cat Zend_Gdata_App_Extension_Category */
        foreach ($entry->getCategory() as $cat)
        {
            if ($cat->getLabel())
            {
                $model->category = $cat->getLabel();
                break;
            }
        }
        return $model;
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
            'select' => $this->title,
            'category' => $this->category,
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
        $entry = $this->getApi()->getVideoEntry($pk);
        $model = new static;
        return $this->populate($model, $entry);
    }
}