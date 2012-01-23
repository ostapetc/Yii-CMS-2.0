<?php

class YmarketSectionAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'View'   => 'Просмотр раздела яндекс маркета',
            'Create' => 'Создание раздела яндекс маркета',
            'Update' => 'Редактирование раздела яндекс маркета',
            'Delete' => 'Удаление раздела яндекс маркета?',
            'Manage' => 'Разделы яндекс маркета',
        );
    }

        
	public function actionView($id)
	{
        $model = $this->loadModel($id);

		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}


	public function actionCreate()
	{
		$model = new YmarketSection;
		
		$form = new BaseForm('ymarket.YmarketSectionForm', $model);
		
		// $this->performAjaxValidation($model);

		if(isset($_POST['YmarketSection']))
		{
			$model->attributes = $_POST['YmarketSection'];
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

		$form = new BaseForm('ymarket.YmarketSectionForm', $model);

		// $this->performAjaxValidation($model);

		if(isset($_POST['YmarketSection']))
		{
			$model->attributes = $_POST['YmarketSection'];
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
		$model=new YmarketSection('search');
		$model->unsetAttributes();
		if(isset($_GET['YmarketSection']))
        {
            $model->attributes = $_GET['YmarketSection'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = YmarketSection::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'ymarket-section-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
