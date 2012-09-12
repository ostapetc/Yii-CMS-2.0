<?

class PageSectionAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'view'   => 'Просмотр Раздела страниц',
            'create' => 'Создание Раздела страниц',
            'update' => 'Редактирование Раздела страниц',
            'delete' => 'Удаление Раздела страниц',
            'manage' => 'Управление Разделами страниц',
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
		$model = new PageSection();
		$form  = new Form('content.PageSectionForm', $model);
		
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
        $form  = new Form('content.PageSectionForm', $model);

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
		$model = new PageSection('search');
		$model->unsetAttributes();

		if(isset($_GET['PageSection']))
        {
            $model->attributes = $_GET['PageSection'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


}
