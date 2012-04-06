<?

class ExampleModelController extends BaseController
{
    public static function actionsTitles()
    {
        return array(
            'View'  => 'Просмотр ExampleModel',
            'index' => 'Управление ExampleModel',
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
		$data_provider = new CActiveDataProvider('ExampleModel');

		$this->render('index', array(
			'data_provider' => $data_provider,
		));
	}


	public function loadModel($id)
	{
		$model = ExampleModel::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}
}
