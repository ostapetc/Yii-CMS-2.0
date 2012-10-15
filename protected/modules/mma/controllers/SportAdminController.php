<?

class SportAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'view'   => 'Просмотр вида спорта',
            'create' => 'Создание вида спорта',
            'update' => 'Редактирование вида спорта',
            'delete' => 'Удаление вида спорта',
            'manage' => 'Управление видами спорта',
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
		$model = new Sport();
		$form  = new Form('mma.SportForm', $model);
		
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
        $form  = new Form('mma.SportForm', $model);

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
		$model = new Sport('search');
		$model->unsetAttributes();

		if(isset($_GET['Sport']))
        {
            $model->attributes = $_GET['Sport'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


}
