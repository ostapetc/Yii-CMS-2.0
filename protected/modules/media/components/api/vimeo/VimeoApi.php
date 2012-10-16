<?php
class VimeoApi extends ApiAbstract
{
    protected $api;
    protected $criteriaClass = 'VimeoApiCriteria';

    public $pk;


    public function getPlayerUrl()
    {
        return 'http://player.vimeo.com/video/38732855?title=1&' .
            http_build_query([//            'oid'  => $this->oid,
//            'id'   => $this->id,
//            'hash' => $this->hash
            ]);
    }


    /**
     * @return Zend_Gdata_YouTube
     */
    public function getApi()
    {
//        return $this->api;
    }


    public function save()
    {
        return true;
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
        throw new CException('no implemented yet');
    }


    protected function _populate($data)
    {
        foreach ($data as $key => $val)
        {
            $this->$key = $val;
        }
    }


    public function count($criteria)
    {
        return 10000;
    }


    public function search($props = [])
    {
        $criteria = clone $this->getDbCriteria();
        $criteria->mergeWith($props);
        $dp = new YouTubeApiDataProvider(new YouTubeApi(), [
            'criteria' => $criteria
        ]);
        return $dp;
    }


    public function attributeNames()
    {
        return [
            'title',
            'img',
            'player_url',
            'pk',
            'oid',
            'id',
            'hash',
            'hd'
        ];
    }


    public function findByPk($pk)
    {
        $this->beforeFind();
        parse_str($pk, $data);
        return $this->populateRecord($data);
    }


    public function parse($source)
    {
        $regexstr = '~
         # Match Vimeo link and embed code
        (?:				            # Group vimeo url
        	https?:\/\/		        # Either http or https
        	(?:[\w]+\.)*		    # Optional subdomains
        	vimeo\.com		        # Match vimeo.com
        	(?:[\/\w]*\/videos?)?	# Optional video sub directory this handles groups links also
        	\/			            # Slash before Id
        	([0-9]+)		        # $1: VIDEO_ID is numeric
        	[^\s]*			        # Not a space
        )				            # End group
        ~ix';

        preg_match($regexstr, $source, $matches);
        stop($matches);
        if (isset($matches[2]))
        {
            $matches[2] = array_values(array_unique($matches[2]));
            foreach ($matches[2] as $key => $id)
            {
                return $id;
            }
        }
        return false;
    }


    public function getThumb($hq = true)
    {
    }


}