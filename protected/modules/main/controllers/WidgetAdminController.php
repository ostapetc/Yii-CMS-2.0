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
                WidgetManager::getVisibleColumnsFilePath($model_id, $widget_id),
                serialize(explode(',', $_POST['columns']))
            );
        }

        $visible_columns = WidgetManager::getVisibleColumns($model_id, $widget_id);
        $hidden_columns = array();

        foreach (array_keys($model->attributes) as $attribute)
        {
            if (in_array($attribute, $visible_columns)) continue;
            $hidden_columns[] = $attribute;
        }

        $this->render('columnsManage', array(
            'visible_columns' => $visible_columns,
            'hidden_columns'  => $hidden_columns,
            'model'           => $model,
        ));
    }
}
