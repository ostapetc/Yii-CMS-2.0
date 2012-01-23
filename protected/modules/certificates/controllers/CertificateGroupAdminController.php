<?php

class CertificateGroupAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Create' => 'Создание группы сертификатов',
            'Update' => 'Редактирование группы сертификатов',
            'Delete' => 'Удаление группы сертификатов',
            'Manage' => 'Управление группами сертификатов',
        );
    }


	public function actionCreate()
	{
		$model = new CertificateGroup;
		
		$form = new BaseForm('certificates.CertificateGroupForm', $model);
		$this->performAjaxValidation($model);

        if ($form->submitted('submit'))
        {
            $model = $form->model;
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

		$form = new BaseForm('certificates.CertificateGroupForm', $model);

		$this->performAjaxValidation($model);

        if ($form->submitted('submit'))
        {
            $model = $form->model;
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
		$model=new CertificateGroup('search');
		$model->unsetAttributes();
		if(isset($_GET['CertificateGroup']))
        {
            $model->attributes = $_GET['CertificateGroup'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}
}
