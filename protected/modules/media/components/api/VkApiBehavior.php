<?php
Yii::import('media.components.api.ApiBehaviorAbstract');

class VkApiBehavior extends ApiBehaviorAbstract
{
    public $icon;
    public $href;


    public function getPlayerUrl()
    {
        return 'http://vk.com/video_ext.php?' . http_build_query([
            'oid'  => $this->oid,
            'id'   => $this->id,
            'hash' => $this->hash
        ]);
    }


    public function parse($source)
    {
        preg_match_all('/(video_ext.php\?)([a-z0-9\-_&=]+)/i', $source, $matches);
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
        throw new CException('not implemented yet');
    }


    public function getThumb()
    {
        throw new CException('not implemented yet');
    }


    public function getServerDir()
    {
        throw new CException('not implemented yet');
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


    public function getUrl()
    {
        throw new CException('not implemented yet');
    }

}