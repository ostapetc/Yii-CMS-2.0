<?php

class OperationAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "AddAllOperations" => "Добавление всех операций модулей",
            "Create"           => "Добавление операции",
            "Update"           => "Редактирование операции",
            "View"             => "Просмотр операции",
            "Manage"           => "Управление операциями",
            "Delete"           => "Удаление операции",
            "GetModules"       => "Получение модулей, JSON",
            "GetModuleActions" => "Получение операции модуля, JSON",
        );
    }


    public function actionAddAllOperations()
    {
        if (isset($_POST["actions"]))
        {
            foreach ($_POST["actions"] as $i => $action)
            {
                Yii::app()->authManager->createOperation($action, $_POST["description"][$i]);
            }

            $this->redirect("AddAllOperations");
        }

        $actions = array();

		$modules = AppManager::getModulesData(true);
		foreach ($modules as $class => $data)
		{
		    $actions = array_merge($actions, AppManager::getModuleActions($class, true));
		}

        $actions_names = array_keys($actions);

        $items = AuthItem::model()->findAllByAttributes(array("type" => AuthItem::TYPE_OPERATION));
        foreach ($items as $item)
        {
            if (in_array($item->name, $actions_names))
            {
                unset($actions[$item->name]);
            }
        }

        $this->render('addAllOperations', array('actions' => $actions));
    }


	public function actionCreate()
	{
		$model = new AuthItem();

		$form = new BaseForm('rbac.OperationForm', $model);

		if (isset($_POST['AuthItem']))
		{
			$model->attributes = $_POST['AuthItem'];
			if ($model->validate())
			{
				Yii::app()->authManager->createOperation(
				    $model->name,
				    $model->description,
				    $model->bizrule,
				    $model->data
				);

			    $this->redirect(array("view", 'id' => $model->name));
			}
		}

		$modules = AuthItem::model()->getModulesWithActions();

		$this->render('create', array(
		    'modules' => $modules,
		    'form'    => $form
		));
	}


	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

        $operation = Yii::app()->authManager->getAuthItem($model->name);
        if (!$operation)
        {
            $this->pageNotFound();
        }

		$form = new BaseForm('rbac.OperationForm', $model);

		if (isset($_POST['AuthItem']))
		{
			$model->attributes = $_POST['AuthItem'];
			if ($model->save())
			{
                $this->redirect(array("manage"));
			}
		}

		$this->render('update', array('form' => $form));
	}


	public function actionView($id)
	{
	    $model = $this->loadModel($id);

	    $this->render('view', array('model' => $model));
	}


	public function actionManage()
	{
	    $model = new AuthItem('search');
	    $model->unsetAttributes();

		if(isset($_GET['AuthItem']))
        {
            $model->attributes = $_GET['AuthItem'];
        }

	    $this->render('manage', array('model' => $model));
	}


	public function actionDelete($id)
	{
	    Yii::app()->authManager->removeAuthItem($id);

		if(!isset($_GET['ajax']))
        {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
	}


	public function loadModel($id)
	{
	    $model = AuthItem::model()->findByPk($id);
	    if (!$model)
	    {
	        $this->pageNotFound();
	    }

	    return $model;
	}


	public function actionGetModules()
	{
	    echo CJSON::encode(AppManager::getModulesData(true));
	}


	public function actionGetModuleActions()
	{
	    $items   = AuthItem::model()->findAllByAttributes(array('type' => AuthItem::TYPE_OPERATION));
	    $actions = AppManager::getModuleActions($_GET['class']);

	    foreach ($items as $item)
	    {
	        if (isset($actions[$item->name]))
	        {
	            unset($actions[$item->name]);
	        }
	    }

	    echo CJSON::encode($actions);
	}
}



