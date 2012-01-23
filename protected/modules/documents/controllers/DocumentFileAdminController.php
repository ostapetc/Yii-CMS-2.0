<?php

class DocumentFileAdminController extends AdminController
{   
    public static function actionsTitles() 
    {
        return array(
            "Create" => "Добавление файла документа",
            "Update" => "Редактирование файла документа",
            "Delete" => "Удаление файла документа",
            "Manage" => "Управление файлами документов",
        );
    }


	public function actionCreate($document_id)
	{
        $document = Document::model()->findByPk($document_id);
        if (!$document)
        {
            $this->pageNotFound();
        }

		$model = new DocumentFile;
		$model->document_id = $document_id;

		$form = new BaseForm('documents.DocumentFileForm', $model);

		if(isset($_POST['DocumentFile']))
		{
			$model->attributes = $_POST['DocumentFile'];
			if($model->save())
            {
                $this->redirect(array('manage', 'document_id' => $document_id));
            }
		}

		$this->render('create', array(
			'form'     => $form,
            'document' => $document
		));
	}


	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		$form = new BaseForm('documents.DocumentFileForm', $model);

		if(isset($_POST['DocumentFile']))
		{
			$model->attributes = $_POST['DocumentFile'];
			if($model->save())
            {
                $this->redirect(array('manage', 'document_id' => $model->document_id));
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


	public function actionManage($document_id)
	{
        $document = $this->loadActionModel($document_id);

		$model=new DocumentFile('search');
		$model->unsetAttributes();
		if(isset($_GET['DocumentFile']))
        {
            $model->attributes = $_GET['DocumentFile'];
        }

		$this->render('manage', array(
			'model'    => $model,
            'document' => $document
		));
	}


	public function loadModel($id)
	{
		$model = DocumentFile::model()->findByPk((int) $id);
		if($model === null)
        {
            $this->pageNotFound();
        }

		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'document-file-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


    public function loadActionModel($document_id)
    {
        $model = Document::model()->findByPk($document_id);
        if ($model === null)
        {
            $this->pageNotFound();
        }

        return $model;
    }
}
