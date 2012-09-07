<?

class PageSectionController extends Controller
{
    public static function actionsTitles()
    {
        return array(
            'create' => 'Создание раздела страниц',
        );
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
            $params = array('done' => true);

            if (isset($_POST['ajax']))
            {
                $params['sections'] = CHtml::listData(PageSection::model()->findAll(array('order' => 'name')), 'id', 'name');
            }

            echo CJSON::encode($params);
        }
        else
        {
            echo CJSON::encode(array('errors' => $model->errors_flat_array));
        }
    }
}
