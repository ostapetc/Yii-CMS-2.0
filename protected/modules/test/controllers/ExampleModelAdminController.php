<?

class ExampleModelAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'View'   => 'Просмотр ExampleModel',
            'Create' => 'Создание ExampleModel',
            'Update' => 'Редактирование ExampleModel',
            'Delete' => 'Удаление ExampleModel',
            'Manage' => 'Управление ExampleModel',
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
		$model = new ExampleModel();
		$form  = new Form('test.ExampleModelForm', $model);
		
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
        $form  = new Form('test.ExampleModelForm', $model);

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
		$model = new ExampleModel('search');
		$model->unsetAttributes();

		if(isset($_GET['ExampleModel']))
        {
            $model->attributes = $_GET['ExampleModel'];
        }

		$this->render('manage', array(
			'model' => $model,
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
