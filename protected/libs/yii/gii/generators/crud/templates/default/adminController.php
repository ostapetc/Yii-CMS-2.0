<? echo "<?\n"; ?>

class <? echo str_replace("Controller", "AdminController", $this->controllerClass); ?> extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'View'   => 'Просмотр чего?',
            'Create' => 'Создание чего?',
            'Update' => 'Редактирование чего?',
            'Delete' => 'Удаление чего?',
            'Manage' => 'Управление чем?',
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
		$model = new <? echo $this->modelClass; ?>;
		
		$form = new BaseForm('<? echo $this->module->name; ?>.<? echo $this->modelClass; ?>Form', $model);
		
		// $this->performAjaxValidation($model);

		if(isset($_POST['<? echo $this->modelClass; ?>']))
		{
			$model->attributes = $_POST['<? echo $this->modelClass; ?>'];
			if($model->save())
            {
                $this->redirect(array('view', 'id' => $model-><? echo $this->tableSchema->primaryKey; ?>));
            }
		}

		$this->render('create', array(
			'form' => $form,
		));
	}


	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		$form = new BaseForm('<? echo $this->module->name; ?>.<? echo $this->modelClass; ?>Form', $model);

		// $this->performAjaxValidation($model);

		if(isset($_POST['<? echo $this->modelClass; ?>']))
		{
			$model->attributes = $_POST['<? echo $this->modelClass; ?>'];
			if($model->save())
            {
                $this->redirect(array('view', 'id' => $model-><? echo $this->tableSchema->primaryKey; ?>));
            }
		}

		$this->render('update', array(
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
		$model=new <? echo $this->modelClass; ?>('search');
		$model->unsetAttributes();
		if(isset($_GET['<? echo $this->modelClass; ?>']))
        {
            $model->attributes = $_GET['<? echo $this->modelClass; ?>'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = <? echo $this->modelClass; ?>::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === '<? echo $this->class2id($this->modelClass); ?>-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
