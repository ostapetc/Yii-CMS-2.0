<?

class MessageAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'view'   => 'Просмотр Сообщения',
            'create' => 'Создание Сообщения',
            'update' => 'Редактирование Сообщения',
            'delete' => 'Удаление Сообщения',
            'manage' => 'Управление Сообщениями',
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
		$model = new Message();
		$form  = new Form('social.MessageForm', $model);
		
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
        $form  = new Form('social.MessageForm', $model);

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
		$model = new Message('search');
		$model->unsetAttributes();

		if(isset($_GET['Message']))
        {
            $model->attributes = $_GET['Message'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


}
