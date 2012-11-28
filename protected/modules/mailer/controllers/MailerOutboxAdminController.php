<?

class MailerOutboxAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'View'     => 'Просмотр исходящего письма',
            'Create'   => 'Создание чего?',
            'Update'   => 'Редактирование чего?',
            'Delete'   => 'Удаление чего?',
            'Manage'   => 'Исходящие письма',
            'BodyView' => 'Посмотр тела письма'
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
		$model = new MailerOutbox;
		$form  = new Form('mailer.MailerOutboxForm', $model);
		
		$this->performAjaxValidation($model);

		if(isset($_POST['MailerOutbox']))
		{
            $model->attributes = $_POST['MailerOutbox'];

            $template = MailerTemplate::model()->findByPk($model->template_id);
            $user     = User::model()->findByPk($model->user_id);

            $model->subject = $template->constructSubject($user);
            $model->body    = $template->constructBody($user);

			if($model->save())
            {
                $this->redirect(array('view', 'id' => $model->id));
            }
		}

		$this->render('create', array(
			'form' => $form,
		));
	}


	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel($id)->delete();

			if(!isset($_GET['ajax']))
            {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
		}
		else
        {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
	}


	public function actionManage()
	{
		$model=new MailerOutbox('search');
		$model->unsetAttributes();
		if(isset($_GET['MailerOutbox']))
        {
            $model->attributes = $_GET['MailerOutbox'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}

    public function actionBodyView($id)
    {
        $this->layout = false;
        echo $this->loadModel($id)->body;
    }
}
