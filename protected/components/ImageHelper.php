<?php
ini_set("memory_limit", -1); //GD - memory killer

class ImageHolder //Класс Image занят под расширение
{
    const TRANSPARENT_PIXEL = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAadEVYdFNvZnR3YXJlAFBhaW50Lk5FVCB2My41LjEwMPRyoQAAAA1JREFUGFdj+P//PwMACPwC/ohfBuAAAAAASUVORK5CYII=';

    private $_htmlOptions;
    private $_watermark;

    private $_dir;
    private $_file;
    private $_size;
    private $_crop;

    private $_src;

    /* Method Markers */
    private static $_round_init = false;
    private $_round = false;
    private $_encode = false;

    const OPTIMIZE_ON = true;       //if true switch on some algorithms to speed up load page in browser.
    const LAZY_LOAD_ON = true;      //you can start load images after load page. optimize_on require
    const ENCODE_ON = true;         //enable base64 encode. optimize_on require
    const ROUND_ON = true;          //enable imgr js plugin. no working with LAZY_LOAD_ON yet

    /**
     * @param strnig $dir
     * @param strnig $file
     * @param array $size
     * @param bool $crop
     */
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
     * @return string
     */
    public function __toString()
    {
        try
        {
            $this->_prepareHtmlOptions();
            $space = CHtml::image(self::TRANSPARENT_PIXEL, '', $this->_htmlOptions);

            if (self::ROUND_ON && $this->_round)
            {
                $this->_round();
            }

            if (self::ENCODE_ON && $this->_encode)
            {
                return $this->_encode();
            }

            if (self::OPTIMIZE_ON && self::LAZY_LOAD_ON)
            {
                return $this->_lazy($space);
            }

            return CHtml::image($this->getSrc(), '', $this->_htmlOptions);
        }
        catch (Exception $e)
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


    /**
     * @param $htmlOptions
     * @return ImageHolder
     */
    public function htmlOptions($htmlOptions)
    {
        $this->_htmlOptions = $htmlOptions;
        return $this;
    }

    /**
     * @return ImageHolder
     */
    public function watermark()
    {
        $this->_watermark = true;
        return $this;
    }

    /**
     * @return string
     */
    public function getSrc()
    {
        if ($this->_src == null)
        {
            $this->_src = ImageHelper::process($this->_dir, $this->_file, $this->_size, $this->_crop);
        }
        return $this->_src;
    }

    /**
     * @return ImageHolder
     */
    public function encode()
    {
        $this->_encode = true;
        return $this;
    }

    /**
     * @param int $radius
     * @param int $size
     * @param string $color
     * @param string $style
     * @return ImageHolder
     */
    public function round($radius, $size = 0, $color = '#000', $style = 'solid')
    {
        if (!self::$_round_init)
        {
            Yii::app()->getClientScript()->registerScriptFile('/js/plugins/clientOptimization/jquery.imgr.min.js');
            self::$_round_init = true;
        }
        $this->_round = array(
            'radius'=>$radius.'px',
            'size'=>$size.'px',
            'color'=>$color,
            'style'=>$style
        );
        return $this;
    }

    /*----------------------------- Private Methods ------------------------------------*/

    /**
     * @return string base64 encode image
     */
    public function _encode()
    {
        $this->_prepareHtmlOptions();
        $file = Yii::app()->getBasePath().'/../'.$this->getSrc();

        if (self::OPTIMIZE_ON && self::ENCODE_ON) //TODO: add some cache
        {
            $base64 = base64_encode(file_get_contents($file));
            $mime = CFileHelper::getMimeType($file);
            $res = 'data:'.$mime.';base64,'.$base64;
        }
        return CHtml::image($res,'', $this->_htmlOptions);
    }


    private function _round()
    {
        Yii::app()->getClientScript()->registerScript(
            __CLASS__ . '#' . $this->_htmlOptions['id'], 'jQuery("#' . $this->_htmlOptions['id'] . '").imgr(' . CJavaScript::encode($this->_round) . ');'
        );
    }

    private function _lazy($space)
    {
        $options = CJavaScript::encode(array(
            'threshold' => 30,
            'effect' => 'fadeIn',

        ));
        Yii::app()->clientScript
            ->registerScriptFile('/js/plugins/clientOptimization/lazyLoad.js')
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

    private function _prepareHtmlOptions()
    {
        $file = $_SERVER['DOCUMENT_ROOT'].'/'.$this->getSrc();
        if (is_file($file))
        {
            list($this->_size['width'], $this->_size['height']) = getimagesize($file);
            list($this->_htmlOptions['width'], $this->_htmlOptions['height']) = array($this->_size['width'], $this->_size['height']);
        }
        if (!isset($this->_htmlOptions['id']))
        {
            $this->_htmlOptions['id'] = uniqid('image_');
        }
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

        return $thumb_path;
    }

}
