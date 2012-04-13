<?

class ExampleAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'View'   => 'Просмотр примера',
            'Create' => 'Создание примера',
            'Update' => 'Редактирование примера',
            'Delete' => 'Удаление примера',
            'Manage' => 'Управление примерами',
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
		$model = new Example();
		$form  = new Form('test.ExampleForm', $model);
		
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
        $form  = new Form('test.ExampleForm', $model);

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
		$model = new Example('search');
		$model->unsetAttributes();

		if(isset($_GET['Example']))
        {
            $model->attributes = $_GET['Example'];
        }

		$this->render('manage', array(
			'model' => $model,
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
