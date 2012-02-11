<?php
ini_set("memory_limit", -1); //GD - memory killer

class ImageHolder //Класс Image занять под расширение
{
    private $_htmlOptions;
    private $_watermark;

    private $_dir;
    private $_file;
    private $_size;
    private $_crop;


    public function __construct($dir, $file, $size, $crop = false)
    {
        $this->_dir  = $dir;
        $this->_file = $file;
        $this->_size = $size;
        $this->_crop = $crop;
        return $this;
    }


    public function __toString()
    {
        return CHtml::image($this->getSrc(), '', $this->_htmlOptions);
    }


    public function getSrc()
    {
        return ImageHelper::process($this->_dir, $this->_file, $this->_size, $this->_crop);
    }


    public function htmlOptions($htmlOptions)
    {
        $this->_htmlOptions = $htmlOptions;
        return $this;
    }


    public function watermark()
    {
        $this->_watermark = true;
        return $this;
    }
}

class ImageHelper
{

    public static function thumb($dir, $file, $size, $crop = false)
    {
        return new ImageHolder($dir, $file, $size, $crop);
    }


    public static function process($dir, $file, $size, $crop = false)
    {
        if (!$file)
        {
            return null;
        }

        $width  = isset($size['width']) && is_numeric($size['width']) ? $size['width'] : 0;
        $height = isset($size['height']) && is_numeric($size['height']) ? $size['height'] : 0;

        $dir = $_SERVER['DOCUMENT_ROOT'] . ltrim($dir, $_SERVER["DOCUMENT_ROOT"]);
        $dir = rtrim($dir, '/') . '/';

        $path_info = pathinfo($file);

        $thumb_name = $width . "x" . $height;

        if ($crop)
        {
            $thumb_name .= "_crop";
        }

        $thumb_name .= "_" . $path_info["basename"];
        $thumb_path = $dir . $thumb_name;
        $file_path  = $dir . $file;

        if (!file_exists($thumb_path))
        {
            if (!file_exists($file_path))
            {
                return null;
            }

            $image = Yii::app()->image->load($dir . $file);

            if ($crop)
            {
                if (!$width && $height)
                {
                    $width = $height;
                }
                elseif (!$height && $width)
                {
                    $height = $width;
                }

                $image_size = getimagesize($file_path);
                if ($image_size[0] < $image_size[1])
                {
                    $image->resize($width, 0);
                }
                else
                {
                    $image->resize(0, $height);
                }

                $image->crop($width, $height);
            }
            else
            {
                $image->resize($width, $height);
            }

            $image->save($thumb_path);

            @chmod($thumb_path, 0777);
        }

        $thumb_path = ltrim($thumb_path, $_SERVER["DOCUMENT_ROOT"]);
        $thumb_path = '/' . ltrim($thumb_path, '/');

        return $thumb_path;
    }

}
