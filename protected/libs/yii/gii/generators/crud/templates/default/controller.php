<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends BaseController
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
		$model = new <?php echo $this->modelClass; ?>;
		
		$form = new BaseForm('module.<?php echo $this->modelClass; ?>Form', $model);
		
		// $this->performAjaxValidation($model);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$model->attributes = $_POST['<?php echo $this->modelClass; ?>'];
			if($model->save())
            {
                $this->redirect(array('view', 'id' => $model-><?php echo $this->tableSchema->primaryKey; ?>));
            }
		}

		$this->render('create', array(
			'form' => $form,
		));
	}


	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		$form = new BaseForm('module.<?php echo $this->modelClass; ?>Form', $model);

		// $this->performAjaxValidation($model);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$model->attributes = $_POST['<?php echo $this->modelClass; ?>'];
			if($model->save())
            {
                $this->redirect(array('view', 'id' => $model-><?php echo $this->tableSchema->primaryKey; ?>));
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


	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('<?php echo $this->modelClass; ?>');

		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}


	public function actionManage()
	{
		$model=new <?php echo $this->modelClass; ?>('search');
		$model->unsetAttributes();
		if(isset($_GET['<?php echo $this->modelClass; ?>']))
        {
            $model->attributes = $_GET['<?php echo $this->modelClass; ?>'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = <?php echo $this->modelClass; ?>::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === '<?php echo $this->class2id($this->modelClass); ?>-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
