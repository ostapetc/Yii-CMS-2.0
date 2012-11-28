<?

class SidebarAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return [
            'View'   => 'Просмотр сайдбара',
            'Create' => 'Создание сайдбара',
            'Update' => 'Редактирование сайдбара',
            'Delete' => 'Удаление сайдбара',
            'Manage' => 'Управление сайдбарами',
        ];
    }

        
	public function actionView($id)
	{
		$this->render('view', [
			'model' => $this->loadModel($id),
        ]);
	}


	public function actionCreate()
	{
		$model = new Sidebar;
		
		$form = new Form('content.SidebarForm', $model);
		
		// $this->performAjaxValidation($model);

		if(isset($_POST['Sidebar']))
		{
			$model->attributes = $_POST['Sidebar'];
			if($model->save())
            {
                $this->redirect(['view', 'id' => $model->id]);
            }
		}

		$this->render('create', [
			'form' => $form,
		]);
	}


	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		$form = new Form('content.SidebarForm', $model);

		// $this->performAjaxValidation($model);

		if(isset($_POST['Sidebar']))
		{
			$model->attributes = $_POST['Sidebar'];
			if($model->save())
            {
                $this->redirect(['view', 'id' => $model->id]);
            }
		}

		$this->render('update', [
			'form' => $form,
		]);
	}


	public function actionDelete($id)
	{
        $this->loadModel($id)->delete();

        if(!isset($_GET['ajax']))
        {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['admin']);
        }
	}


	public function actionManage()
	{
		$model=new Sidebar('search');
		$model->unsetAttributes();
		if(isset($_GET['Sidebar']))
        {
            $model->attributes = $_GET['Sidebar'];
        }

		$this->render('manage', [
			'model' => $model,
		]);
	}

}
