<? echo "<?\n"; ?>

class <?= $class ?>AdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'View'   => 'Просмотр <?= $genetive ?>',
            'Create' => 'Создание <?= $genetive ?>',
            'Update' => 'Редактирование <?= $genetive ?>',
            'Delete' => 'Удаление <?= $genetive ?>',
            'Manage' => 'Управление <?= $instrumental ?>',
        );
    }

        
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}


	public function actionCreate()
	{
		$model = new <?= $class ?>();
		$form  = new Form('<?= $module ?>.<?= $class ?>Form', $model);
		
		$this->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
		{
            $this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('create', array(
			'form' => $form,
		));
	}


	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
        $form  = new Form('<?= $module ?>.<?= $class ?>Form', $model);

	    $this->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
		{
            $this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('update', array(
			'form' => $form,
		));
	}


	public function actionDelete($id)
	{
		if(!Yii::app()->request->isPostRequest)
		{
            $this->badRequest();
        }

        $this->loadModel($id)->delete();

        if(!isset($_GET['ajax']))
        {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
	}


	public function actionManage()
	{
		$model = new <?= $class ?>('search');
		$model->unsetAttributes();

		if(isset($_GET['<?= $class ?>']))
        {
            $model->attributes = $_GET['<?= $class ?>'];
        }

		$this->render('manage', array(
			'model' => $model,
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
