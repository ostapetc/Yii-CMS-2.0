<?php

class WidgetAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'columnsManage' => 'Настройка колонок виджета'
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

            if (isset($_GET['redirect']))
            {
                $this->redirect(base64_decode($_GET['redirect']));
            }
        }

        $visible_columns = WidgetManager::getVisibleColumns($model_id, $widget_id);
        $hidden_columns  = array();
        $attributes      = array_keys($model->attributeLabels());
        $visible_columns = array_intersect($visible_columns, $attributes);

        foreach ($attributes as $attribute)
        {
            if ($attribute == 'captcha') continue;

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
