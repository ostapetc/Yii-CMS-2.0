<?

class PageSectionController extends Controller
{
    public static function actionsTitles()
    {
        return array(
            'View'  => 'Просмотр Раздела страниц',
            'Index' => 'Список Раздел страниц',
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
		$data_provider = new CActiveDataProvider('PageSection');

		$this->render('index', array(
			'data_provider' => $data_provider,
		));
	}


	public function loadModel($id)
	{
		$model = PageSection::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}
}
