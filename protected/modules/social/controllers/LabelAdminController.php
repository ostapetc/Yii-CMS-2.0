<?

class LabelAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'View'   => 'Просмотр Ярлыка',
            'Create' => 'Создание Ярлыка',
            'Update' => 'Редактирование Ярлыка',
            'Delete' => 'Удаление Ярлыка',
            'Manage' => 'Управление Ярлыками',
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
		$model = new Label();
		$form  = new Form('social.LabelForm', $model);
		
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
        $form  = new Form('social.LabelForm', $model);

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
        $this->loadModel($id)->delete();

        if(!isset($_GET['ajax']))
        {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
	}


	public function actionManage()
	{
		$model = new Label('search');
		$model->unsetAttributes();

		if(isset($_GET['Label']))
        {
            $model->attributes = $_GET['Label'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


}
