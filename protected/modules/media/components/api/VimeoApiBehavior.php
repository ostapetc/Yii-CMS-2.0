<?php
Yii::import('media.components.api.ApiBehaviorAbstract');

class VimeoApiBehavior extends ApiBehaviorAbstract
{
    public $icon;
    public $href;


    public function getPlayerUrl()
    {
        return 'http://player.vimeo.com/video/38732855?title=1&';
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


    public function getType()
    {
        return MediaFile::TYPE_VIDEO;
    }


    public function getHref()
    {
        return $this->href;
    }


    public function getPreviewArray()
    {
        $player = $this->getPlayerUrl();
        if ($player)
        {
            return [
                'type' => 'iframe',
                'val'  => $player
            ];
        }
        else
        {
            return [
                'type' => 'img',
                'val'  => $this->icon
            ];
        }
    }


    public function getPreview($size_name = null)
    {

    }

}