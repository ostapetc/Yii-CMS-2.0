<?php

class WidgetAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'ColumnsManage' => 'Настройка колонок виджета'
        );
    }


    public function actionColumnsManage($model_id, $widget_id)
    {
        $model = ActiveRecord::model($model_id);

        if (isset($_POST['columns']))
        {
            file_put_contents(
                self::getVisibleColumnsFilePath($model_id, $widget_id),
                serialize(explode(',', $_POST['columns']))
            );
        }

        $labels  = $model->attributeLabels();

        $visible_columns = self::getVisibleColumns($model_id, $widget_id);
        $hidden_columns = array();

        foreach (array_keys($model->attributes) as $attribute)
        {
            if (!isset($labels[$attribute]) || empty($labels[$attribute]) || in_array($attribute, $visible_columns)) continue;
            $hidden_columns[$attribute] = $labels[$attribute];
        }

        $this->render('columnsManage', array(
            'visible_columns' => $visible_columns,
            'hidden_columns'  => $hidden_columns
        ));
    }


    public static function getVisibleColumns($model_id, $widget_id)
    {
        $file_path = self::getVisibleColumnsFilePath($model_id, $widget_id);
        if (file_exists($file_path))
        {
            return unserialize(file_get_contents($file_path));
        }
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
