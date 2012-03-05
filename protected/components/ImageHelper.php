<?php
ini_set("memory_limit", -1); //GD - memory killer

class ImageHolder //Класс Image занят под расширение
{
    const TRANSPARENT_PIXEL = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACx
jwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAadEVYdFNvZnR3YXJlAFBhaW50Lk5FVCB2My41
LjEwMPRyoQAAAA1JREFUGFdj+P//PwMACPwC/ohfBuAAAAAASUVORK5CYII=';

    private $_htmlOptions;
    private $_watermark;

    private $_dir;
    private $_file;
    private $_size;
    private $_crop;

    private $_src;

    const OPTIMIZE_ON = true;       //if true switch on some algorithms to speed up load page in browser.
    const LAZY_LOAD_ON = false;      //you can start load images after load page. optimize_on require
    const NO_LOAD_IF_NO_SEE = false;  //images start load when they appear on the screen. lazy_load_on require
    const ENCODE_ON = true;         //enable base64 encode. optimize_on require


    public function __construct($dir, $file, array $size, $crop = false)
    {
        //internal variables

        $this->_dir  = $dir;
        $this->_file = $file;
        $this->_size = $size;
        $this->_crop = $crop;
        return $this;
    }

    /**
     *
     *
     * @return string
     */
    public function __toString()
    {
        try
        {
            list($this->_htmlOptions['width'], $this->_htmlOptions['height']) = array($this->_size['width'], $this->_size['height']);
            $img = CHtml::image($this->getSrc(), '', $this->_htmlOptions);
            $space = CHtml::image(self::TRANSPARENT_PIXEL, '', $this->_htmlOptions);

            if (self::OPTIMIZE_ON && self::LAZY_LOAD_ON)
            {
                $options = CJavaScript::encode(array(
                    'threshold' => 30,
                    'effect' => 'fadeIn',

                ));
                Yii::app()->clientScript
                    ->registerScriptFile('/js/plugins/lazyLoad.js')
                    ->registerScript('lazy_load', "$('div.lazy-load').show().lazyload({$options})");

                $this->_htmlOptions['data-original'] = $this->getSrc();
                if (!$this->_htmlOptions['data-original'])
                {
                    return $space;
                }
                $res = $space;
//                $res .= CHtml::tag('noscript', array(), $img); //old image view!!!

                $class = 'lazy-load';
                if (isset($this->_htmlOptions['class']))
                {
                    $class = $this->_htmlOptions['class'] . ' ' . $class;
                }
                $this->_htmlOptions['class'] = $class;

                return CHtml::tag('div', $this->_htmlOptions, $res);
            }
            else
            {
                return $img;
            }
        } catch (Exception $e)
        {
            if (YII_DEBUG)
            {
                Yii::app()->handleException($e);
            }
            else
            {
                //какой-нибудь лог
            }
            return $space;
        }
    }


    public function getSrc()
    {
        if ($this->_src == null)
        {
            list($this->_src, $this->_size['width'], $this->_size['height']) = ImageHelper::process($this->_dir, $this->_file, $this->_size, $this->_crop);
        }
        return $this->_src;
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

    /**
     * @return string base64 encode image
     */
    public function encode()
    {
        $file = Yii::app()->getBasePath().'/../'.$this->getSrc();

        if (self::OPTIMIZE_ON && self::ENCODE_ON) //TODO: add some cache
        {
            $base64 = base64_encode(file_get_contents($file));
            $mime = CFileHelper::getMimeType($file);
            $res = 'data:'.$mime.';base64,'.$base64;
        }
        return CHtml::image($res,'', $this->_htmlOptions);
    }
}

class ImageHelper
{

    public static function thumb($dir, $file, array $size, $crop = false)
    {
        return new ImageHolder($dir, $file, $size, $crop);
    }


    public static function process($dir, $file, array $size, $crop = false)
    {
        if (!$file)
        {
            return null;
        }

        $width  = isset($size['width']) && is_numeric($size['width']) ? $size['width'] : 0;
        $height = isset($size['height']) && is_numeric($size['height']) ? $size['height'] : 0;

        //normalize dir
        $doc_root = $_SERVER['DOCUMENT_ROOT'];
        if (substr($dir, 0, strlen($doc_root) !== $doc_root))
        {
            $dir = $doc_root . $dir;
        }

        $dir       = rtrim($dir, '/') . '/';
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

        $thumb_path = str_replace($_SERVER["DOCUMENT_ROOT"], "", $thumb_path);
        $thumb_path = '/' . ltrim($thumb_path, '/');

        return array($thumb_path, $width, $height);
    }

}
