<? echo "<?\n"; ?>

class <?= $class ?>Controller extends Controller
{
    public static function actionsTitles()
    {
        return array(
            'view'  => 'Просмотр <?= $genetive ?>',
            'index' => 'Список <?= $accusative ?>',
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
		$data_provider = new CActiveDataProvider('<?= $class ?>');

		$this->render('index', array(
			'data_provider' => $data_provider,
		));
	}


	public function loadModel($id)
	{
		$model = <?= $class ?>::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}
}
