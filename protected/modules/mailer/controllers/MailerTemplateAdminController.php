<?

class MailerTemplateAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'view'     => 'Просмотр шаблона рассылки',
            'create'   => 'Создание шаблона рассылки',
            'update'   => 'Редактирование шаблона рассылки',
            'delete'   => 'Удаление шаблона рассылки',
            'manage'   => 'Управление шаблонами рассылки',
            'bodyView' => 'Посмотр тела письма'
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
		$model = new MailerTemplate();
		$form  = new Form('mailer.MailerTemplateForm', $model);
		
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
        $model->body = file_get_contents($model->getFilePath());

        $form = new Form('mailer.MailerTemplateForm', $model);

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
		$model = new MailerTemplate('search');
		$model->unsetAttributes();

		if(isset($_GET['MailerTemplate']))
        {
            $model->attributes = $_GET['MailerTemplate'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}



    public function actionBodyView($id)
    {
        $this->layout = false;
        echo $this->loadModel($id)->constructBody(User::model()->find());
    }
}
