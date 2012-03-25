<?php

class OutboxEmailAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'View'   => 'Просмотр исходящего письма',
            'Create' => 'Создание чего?',
            'Update' => 'Редактирование чего?',
            'Delete' => 'Удаление чего?',
            'Manage' => 'Исходящие письма',
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
		$model = new OutboxEmail;
		
		$form = new BaseForm('mailer.OutboxEmailForm', $model);
		
		// $this->performAjaxValidation($model);

		if(isset($_POST['OutboxEmail']))
		{
			$model->attributes = $_POST['OutboxEmail'];
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

		$form = new BaseForm('mailer.OutboxEmailForm', $model);

		// $this->performAjaxValidation($model);

		if(isset($_POST['OutboxEmail']))
		{
			$model->attributes = $_POST['OutboxEmail'];
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
		$model=new OutboxEmail('search');
		$model->unsetAttributes();
		if(isset($_GET['OutboxEmail']))
        {
            $model->attributes = $_GET['OutboxEmail'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = OutboxEmail::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'outbox-email-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
