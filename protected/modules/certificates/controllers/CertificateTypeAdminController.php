<?php

class CertificateTypeAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Create' => 'Создание типа сертификатов',
            'Update' => 'Редактирование типа сертификатов',
            'Delete' => 'Удаление типа сертификатов',
            'Manage' => 'Управление типами сертификатов',
        );
    }

    
	public function actionCreate()
	{
		$model = new CertificateType;
		
		$form = new BaseForm('certificates.CertificateTypeForm', $model);
		
		// $this->performAjaxValidation($model);

		if(isset($_POST['CertificateType']))
		{
			$model->attributes = $_POST['CertificateType'];
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

		$form = new BaseForm('certificates.CertificateTypeForm', $model);

		// $this->performAjaxValidation($model);

		if(isset($_POST['CertificateType']))
		{
			$model->attributes = $_POST['CertificateType'];
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
		$model=new CertificateType('search');
		$model->unsetAttributes();
		if(isset($_GET['CertificateType']))
        {
            $model->attributes = $_GET['CertificateType'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}


	public function loadModel($id)
	{
		$model = CertificateType::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'certificate-type-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
