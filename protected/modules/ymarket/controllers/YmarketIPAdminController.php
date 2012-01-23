<?php

class YmarketIPAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Create' => 'Добавление IP адреса яндекс маркета',
            'Update' => 'Редактирование IP адреса яндекс маркета',
            'Delete' => 'Удаление IP адреса яндекс маркета',
            'Manage' => 'IP адреса яндекс маркета',
        );
    }


	public function actionCreate()
	{
		$model = new YmarketIP;
		
		$form = new BaseForm('ymarket.YmarketIPForm', $model);

		// $this->performAjaxValidation($model);

		if(isset($_POST['YmarketIP']))
		{
			$model->attributes = $_POST['YmarketIP'];
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

		$form = new BaseForm('ymarket.YmarketIPForm', $model);

		// $this->performAjaxValidation($model);

		if(isset($_POST['YmarketIP']))
		{
			$model->attributes = $_POST['YmarketIP'];
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
		$model=new YmarketIP('search');
		$model->unsetAttributes();
		if(isset($_GET['YmarketIP']))
        {
            $model->attributes = $_GET['YmarketIP'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = YmarketIP::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'ymarket-ip-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
