<?

class QuizAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'view'   => 'Просмотр Теста',
            'create' => 'Создание Теста',
            'update' => 'Редактирование Теста',
            'delete' => 'Удаление Теста',
            'manage' => 'Управление Тестами',
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
		$model = new Quiz();
		$form  = new Form('quiz.QuizForm', $model);
		
		$this->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
		{
            $model->updateTopicsRels();
            $this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('create', array(
			'form' => $form,
		));
	}


	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
        $form  = new Form('quiz.QuizForm', $model);

	    $this->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
		{
            $model->updateTopicsRels();
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
		$model = new Quiz('search');
		$model->unsetAttributes();

		if(isset($_GET['Quiz']))
        {
            $model->attributes = $_GET['Quiz'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = Quiz::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}
}
