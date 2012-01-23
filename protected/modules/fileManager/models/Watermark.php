<?php
class Watermark
{
    public static $checked;

    public static $watermark_dir;
    public static $watermark_padding;
    public static $watermark_file;
    public static $watermark_default_position;
    public static $watermark_default_img_size;
    public static $watermark_default_watermark_size;

    public static $path_info;
    public static $image_size;
    public static $dir;
    public static $base_name;

    public static $ratio;

    private static function init($path, $position)
    {
        if (!self::$checked)
        {
            self::$checked = Setting::checkRequired(array(
                'watermark_padding',
                'watermark_default_position',
                'watermark_file',
                'watermark_default_img_size',
                'watermark_default_watermark_size',
            ), 'fileManager');

            foreach (Setting::model()->findCodesValues('fileManager') as $key => $val)
            {
                self::$$key = str_replace(' ', '_', $val);
            }
            self::$watermark_dir = Setting::UPLOAD_DIR;
        }

        //size
        $path_info = pathinfo($path);

        //path
        self::$dir        = ImageHelper::normalizeDir($path_info['dirname'].'/');
        self::$base_name  = $path_info['basename'];
        self::$image_size = getimagesize($path);

        //ratio
        self::calcRatio();

        //position
        if ($position === false)
        {
            $position = self::$watermark_default_position;
        }
//        self::ratioWalk($position);
//        self::ratioWalk(self::$watermark_padding);

        $position = self::normalizePosition($position);
        return array(
            $position,
            self::getResultName($position)
        );
    }

    private static function ratioWalk(&$arr)
    {
        $tmp = explode('_', $arr);
        foreach($tmp as $key=>$val)
        {
            $tmp[$key] = $val*self::$ratio;
        }
        $arr = implode('_', $tmp);
    }

    public static function set($path, $position = false, $img_tag = false, $attr_string = "border='0'")
    {
        list($position, $dist_img_name) = self::init($path, $position);

        $dist_img_path = self::$dir.$dist_img_name;

        if (!file_exists($dist_img_path))
        {
            if (!file_exists($path))
            {
                return null;
            }

            $handler                  = new Upload($path);
            $handler->image_watermark = '.'.self::getScaleWatermark();

            list($handler->image_watermark_x, $handler->image_watermark_y) = $position;
            list($handler->file_new_name_body, $ext) = explode('.', $dist_img_name);

            $handler->process(self::$dir);

            @chmod($dist_img_path, 0777);
        }

        $dist_img_path = ImageHelper::normalizePath($dist_img_path);

        if ($img_tag)
        {
            return "<img src='{$dist_img_path}' {$attr_string} />";
        }
        else
        {
            return $dist_img_path;
        }
    }

    private static function normalizePosition($position)
    {
        list($ww, $wh) = explode('_', self::$watermark_default_watermark_size);
        list($px, $py) = explode('_', $position);
        list($p1, $p2, $p3, $p4) = explode('_', self::$watermark_padding);
        list($iw, $ih) = self::$image_size;

        if ($p1 > $py)
        {
            $py = $p1;
        }
        if ($p2 > ($iw - $px))
        {
            $px = ($iw - $p2 - $ww * self::$ratio);
        }
        if ($p3 > ($ih - $py))
        {
            $py = ($ih - $p3 - $wh * self::$ratio);

        }
        if ($p4 > $px)
        {
            $px = $p4;
        }

        return array(
            $px,
            $py
        );
    }

    private static function getResultName($position)
    {
        list($w, $h) = explode('_', self::$watermark_default_watermark_size);

        return implode('_', array(
            "watermark",
            implode('_', $position),
            round($w * self::$ratio),
            round($h * self::$ratio),
            self::$base_name
        ));
    }

    /**
     * make a watermark small copy
     *
     * @static
     *
     * @param string $file   path to watermark image
     * @param string $side   scale side "width"|"height"
     * @param int    $points size of result image
     * @param string $units  type of $points "px"|"%"
     *
     * @return mixed|null|string src of new watermark
     */
    private static function getScaleWatermark()
    {
        list($width, $height) = explode('_', self::$watermark_default_watermark_size);
        return ImageHelper::thumb(self::$watermark_dir, self::$watermark_file, round($width * self::$ratio), round(
                $height * self::$ratio), false, '', false);
    }

    /**
     * Возвращает ближайшее к 1 отношение
     *
     * @static
     *
     * @param string $img_big изображение относительно которого нужно выщитать отношение
     *
     * @return float
     */
    private static function calcRatio()
    {
        list($big_width, $big_height) = self::$image_size;
        list($small_width, $small_height) = explode('_', self::$watermark_default_img_size);
        $r1 = $big_width / $small_width;
        $r2 = $big_height / $small_height;
        if ($r1 < 1 || $r2 < 1)
        {
            $r1 = $r2 = 1;
        }
        self::$ratio = min($r1, $r2);
    }

}