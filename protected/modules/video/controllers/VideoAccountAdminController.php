<?

class VideoAccountAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'view'   => 'Просмотр аккаунта',
            'create' => 'Создание аккаунта',
            'update' => 'Редактирование аккаунта',
            'delete' => 'Удаление аккаунта',
            'manage' => 'Управление аккаунтами',
        );
    }

        
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}


	public function actionCreate($service = null)
	{
        if ($service)
        {
            if (!isset(VideoAccount::$service_options[$service]))
            {
                $this->badRequest();
            }

            $model = new VideoAccount($service);
            $model->service = $service;

            $form = new Form('video.VideoAccountForm', $model);

            $this->performAjaxValidation($model);

            if ($form->submitted() && $model->save())
            {
                $this->redirect(array('view', 'id' => $model->id));
            }

            $this->render('create', array(
                'form' => $form,
            ));
        }
        else
        {
            $this->page_title = t('Выберите сервис');

            $this->render('selectAccaunt', array(
                'services' => VideoAccount::$service_options
            ));
        }
	}


	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
        $form  = new Form('video.VideoAccountForm', $model);

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
		$model = new VideoAccount('search');
		$model->unsetAttributes();

		if(isset($_GET['VideoAccount']))
        {
            $model->attributes = $_GET['VideoAccount'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = VideoAccount::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}
}
