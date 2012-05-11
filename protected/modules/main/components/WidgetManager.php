<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 27.04.12
 * Time: 13:39
 * To change this template use File | Settings | File Templates.
 */
class WidgetManager
{
    public static function getVisibleColumns($model_id, $widget_id)
    {
        $file_path = self::getVisibleColumnsFilePath($model_id, $widget_id);
        if (file_exists($file_path))
        {
            return unserialize(file_get_contents($file_path));
        }

        return array();
    }


    public static function getVisibleColumnsFilePath($model_id, $widget_id)
    {
        $dir_path = RUNTIME_PATH . 'widgets' . DS;
        if (!is_dir($dir_path))
        {
            mkdir($dir_path, 0777);
            chmod($dir_path, 0777);
        }

        return $dir_path . 'columns_' . $model_id . '_' .$widget_id;
    }
}
