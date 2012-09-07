<?php

class TagController extends Controller
{
    public static function actionsTitles()
    {
        return array(
            'autoComplete' => 'Автодополнение тегов',
            'create'       => 'Добавление тега'
        );
    }


    public function actionAutoComplete($term)
    {
        $sql = "SELECT GROUP_CONCAT(name) AS tags_concat
                       FROM " . Tag::tableName() . "
                       WHERE name LIKE :term";
        $term = "%{$term}%";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':term', $term, PDO::PARAM_STR);

        echo CJSON::encode(explode(',', $command->queryScalar()));
    }


    public function actionCreate()
    {
        if (!$this->request->isPostRequest || !isset($_POST['Tag']))
        {
            $this->badRequest();
        }

        $model = new Tag(Tag::SCENARIO_CREATE);
        $model->attributes = $_POST['Tag'];

        if ($model->save())
        {
            $params = array(
                'done' => true,
                'tags' => CHtml::listData(Tag::model()->findAll(array('order' => 'name')), 'id', 'name')
            );
        }
        else
        {
            $params = array('errors' => $model->errors_flat_array);
        }

        echo CJSON::encode($params);
    }
}
