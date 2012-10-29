<?

class PageSectionController extends ClientController
{
    public static function actionsTitles()
    {
        return [
            'create' => 'Создание раздела страниц',
        ];
    }


    public function actionCreate()
    {
        if (!isset($_POST['PageSection']))
        {
            $this->badRequest();
        }

        $model = new PageSection(ActiveRecord::SCENARIO_CREATE);
        $model->attributes = $_POST['PageSection'];
        if ($model->save())
        {
            $params = ['done' => true];
            if (isset($_POST['ajax']))
            {
                $params['sections'] = CHtml::listData(PageSection::model()->findAll(['order' => 'name']), 'id', 'name');
            }
        }
        else
        {
            $params = ['errors' => $model->errors_flat_array];
        }

        echo CJSON::encode($params);
    }
}
