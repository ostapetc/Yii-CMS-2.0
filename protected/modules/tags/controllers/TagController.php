<?php

class TagController extends ClientController
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
        $model = Tag::model();
        $criteria = new CDbCriteria();
        $criteria->select = 'name';
        $criteria->compare('name', $term, true);
        $model->setDbCriteria($criteria);
        $result = $model->limit(15)->findAll();
        echo CJSON::encode(array_values(CHtml::listData($result, 'name', 'name')));
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
