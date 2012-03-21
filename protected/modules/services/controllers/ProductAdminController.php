<?php

class ProductAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'View'   => 'Просмотр продукта',
            'Create' => 'Добавление продукта',
            'Update' => 'Редактирование продукта',
            'Delete' => 'Удаление продукта',
            'Manage' => 'Управление продуктами',
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
		$model = new Product;
		
		$form = new BaseForm('services.ProductForm', $model);
		
		$this->performAjaxValidation($model);

		if(isset($_POST['Product']))
		{
			$model->attributes = $_POST['Product'];
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

		$form = new BaseForm('services.ProductForm', $model);

		$this->performAjaxValidation($model);

		if(isset($_POST['Product']))
		{
			$model->attributes = $_POST['Product'];
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
		$model=new Product('search');
		$model->unsetAttributes();
		if(isset($_GET['Product']))
        {
            $model->attributes = $_GET['Product'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = Product::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
