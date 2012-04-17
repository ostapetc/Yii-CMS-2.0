<?

class ExampleController extends Controller
{
    public static function actionsTitles()
    {
        return array(
            'View'  => 'Просмотр примера',
            'Index' => 'Список пример',
        );
    }

        
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}


	public function actionIndex()
	{
		$data_provider = new CActiveDataProvider('Example');

		$this->render('index', array(
			'data_provider' => $data_provider,
		));
	}


	public function loadModel($id)
	{
		$model = Example::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}
}
