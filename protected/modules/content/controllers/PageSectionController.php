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
            echo CJSON::encode(array('done' => true));
        }
        else
        {
            echo CJSON::encode(array('errors' => $model->errors_array));
        }
    }
}
