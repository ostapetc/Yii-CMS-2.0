<?php

class BannerAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'View'   => 'Просмотр банера',
            'Create' => 'Создание банера',
            'Update' => 'Редактирование банера',
            'Delete' => 'Удаление банера',
            'Manage' => 'Управление банерами',
            'MovePosition' => 'Изменение приоритета банера'
        );
    }


    public function actionMovePosition()
    {
        Banner::model()->swapPosition($_POST['from'], $_POST['to']);
    }

        
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}


	public function actionCreate()
	{
		$model = new Banner(Banner::SCENARIO_CREATE);

        $this->performAjaxValidation($model);
        $form = new BaseForm('banners.BannerForm', $model);

        if ($form->submitted('submit'))
        {
            $model              = $form->model;
            $model->date_active = $_POST['Banner']['date_active'];

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
        $model->scenario = Banner::SCENARIO_UPDATE;

        $this->performAjaxValidation($model);
        $form = new BaseForm('banners.BannerForm', $model);

        if ($form->submitted('submit'))
        {
            $model              = $form->model;
            $model->date_active = $_POST['Banner']['date_active'];

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
		$model=new Banner('search');
		$model->unsetAttributes();
		if(isset($_GET['Banner']))
        {
            $model->attributes = $_GET['Banner'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}

}
