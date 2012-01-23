<?php
ini_set("memory_limit", -1); //GD - memory killer
class ImageHelper
{
    public static function thumb($dir, $file, $width = null, $height = null, $crop = false, $attr_string = "border='0'")
    {
        if (!$file)
        {
            return null;
        }

        if (substr($dir, 0, strlen($_SERVER['DOCUMENT_ROOT'])) != $_SERVER['DOCUMENT_ROOT'])
        {
            $dir = $_SERVER['DOCUMENT_ROOT'] . $dir;
        }

        if (substr($dir, -1) != '/')
        {
            $dir .= '/';
        }

        $width  = is_numeric($width) ? $width : 0;
        $height = is_numeric($height) ? $height : 0;

        $path_info = pathinfo($file);

        $thumb_name = $width . "x" . $height;

        if ($crop)
        {
            $thumb_name .= "_crop";
        }

        $thumb_name .= "_" . $path_info["basename"];

        $thumb_path = $dir . $thumb_name;

        $file_path = $dir . $file;

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

        if (substr($thumb_path, 0, 1) != "/")
        {
            $thumb_path = "/" . $thumb_path;
        }

        return "<img src='{$thumb_path}' {$attr_string} />";
    }
}
