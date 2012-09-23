<?php
/** 
 * 
 * !Attributes - атрибуты БД
 * @property                    $title
 * @property                    $img
 * @property                    $size
 * @property                    $player_url
 * @property                    $view_count
 * @property                    $raters
 * @property                    $average
 * @property                    $id
 * @property                    $author_name
 * @property                    $author_uri
 * 
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property Zend_Gdata_YouTube $api
 * @property                    $primaryKey
 * @property                    $dbCriteria
 * 
 */

class YouTubeApi extends ApiAbstract
{
    protected $api;

    public $entry;

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


    public function getTitle()
    {
        return $this->entry->getVideoTitle();
    }


    public function getAverage()
    {
        $this->entry->getVideoRatingInfo();
        return $rating['average'];
    }


    public function getNumRaters()
    {
        $this->entry->getVideoRatingInfo();
        return $rating['numRaters'];
    }


    public function getViewCount()
    {
        return $this->entry->getStatistics()->getViewCount();
    }


    public function getAuthorName()
    {
        $author = reset($this->entry->getAuthor());
        /** @var $author Zend_Gdata_App_Extension_Author */
        return $author->getName()->getText();
    }


    public function getAuthorUri()
    {
        $author = reset($this->entry->getAuthor());
        /** @var $author Zend_Gdata_App_Extension_Author */

        return "http://www.youtube.com/user/" . $this->author_name;
    }


    public function getCategory()
    {
        /** @var $cat Zend_Gdata_App_Extension_Category */
        foreach ($this->entry->getCategory() as $cat)
        {
            if ($cat->getLabel())
            {
                return $cat->getLabel();
            }
        }
        return null;
    }


    public function save()
    {
        throw new CException('no implemented yet');
    }


    public function getHref()
    {
        throw new CException('no implemented yet');
    }


    public function getUrl()
    {
        return $this->player_url;
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
        $this->setPk($entry->getVideoId());
        $this->entry = $entry;
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
            'pk',
            'author_name',
            'author_uri',
        );
    }


    public function findByPk($pk)
    {
        $this->beforeFind();
        $entry = $this->getApi()->getVideoEntry($pk);
        return $this->populateRecord($entry);
    }
}