<?php

class SidebarAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'View'   => 'Просмотр сайдбара',
            'Create' => 'Создание сайдбара',
            'Update' => 'Редактирование сайдбара',
            'Delete' => 'Удаление сайдбара',
            'Manage' => 'Управление сайдбарами',
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
		$model = new Sidebar;
		
		$form = new Form('content.SidebarForm', $model);
		
		// $this->performAjaxValidation($model);

		if(isset($_POST['Sidebar']))
		{
			$model->attributes = $_POST['Sidebar'];
			if($model->save())
            {
                $this->redirect(array('view', 'id' => $model->id));
            }
		}

		$this->render('create', array(
			'form' => $form,
		));
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
                $this->redirect(array('view', 'id' => $model->id));
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
		$model=new Sidebar('search');
		$model->unsetAttributes();
		if(isset($_GET['Sidebar']))
        {
            $model->attributes = $_GET['Sidebar'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = Sidebar::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'sidebar-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
