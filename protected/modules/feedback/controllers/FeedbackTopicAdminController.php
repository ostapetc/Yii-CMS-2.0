<?php

class FeedbackTopicAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Create' => 'Создание темы',
            'Update' => 'Редактирование темы',
            'Delete' => 'Удаление темы',
            'Manage' => 'Управление темами',
        );
    }


	public function actionCreate()
	{
		$model = new FeedbackTopic;
		
		$form = new BaseForm('feedback.FeedbackTopicForm', $model);
		
		$this->performAjaxValidation($model);

		if(isset($_POST['FeedbackTopic']))
		{
			$model->attributes = $_POST['FeedbackTopic'];
			if($model->save())
            {
                $this->redirect(array('manage'));
            }
		}

		$this->render('create', array(
			'form' => $form,
		));
	}


	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		$form = new BaseForm('feedback.FeedbackTopicForm', $model);

	    $this->performAjaxValidation($model);

		if(isset($_POST['FeedbackTopic']))
		{
			$model->attributes = $_POST['FeedbackTopic'];
			if($model->save())
            {
                $this->redirect(array('manage'));
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
		$model=new FeedbackTopic('search');
		$model->unsetAttributes();
		if(isset($_GET['FeedbackTopic']))
        {
            $model->attributes = $_GET['FeedbackTopic'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = FeedbackTopic::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'feedback-topic-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
