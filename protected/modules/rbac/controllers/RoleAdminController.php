<?php

class RoleAdminController extends AdminController 
{   
    public static function actionsTitles() 
    {
        return array(
            "Create"     => "Добавление роли",
            "Update"     => "Редактирование роли",
            "View"       => "Просмотр роли",
            "Manage"     => "Управление ролями",
            "Delete"     => "Удаление роли",
			"Assignment" => "Назначение ролей"
        );
    }


	public function actionCreate() 
	{	
		$model = new AuthItem();

		$form = new BaseForm('rbac.RoleForm', $model);

		if (isset($_POST['AuthItem']))
		{
			$model->attributes = $_POST['AuthItem'];
			if ($model->validate())
			{
				$role = Yii::app()->authManager->createRole(
				    $model->name, 
				    $model->description, 
				    $model->bizrule, 
				    $model->data
			    );	
			    
			    if (isset($_POST['AuthItem']['parent']) && $_POST['AuthItem']['parent'])
			    {  
			        Yii::app()->authManager->addItemChild($_POST['AuthItem']['parent'], $model->name);
			    }
			    
			    $this->redirect($this->redirect($this->createUrl("view", array('id' => $model->name))));
			}
		}
		
		$this->render('create', array('form' => $form));
	}
	
	
	public function actionUpdate($id) 
	{	
		$model = $this->loadModel($id);

        $this->protectSystemRoles($model);

        $role = Yii::app()->authManager->getAuthItem($model->name);
        if (!$role) 
        {
            $this->pageNotFound();
        }
        
		$form = new BaseForm('rbac.RoleForm', $model);

		if (isset($_POST['AuthItem']))
		{
			$model->attributes = $_POST['AuthItem'];
			if ($model->validate())
			{
                $role->name        = $model->name;
                $role->description = $model->description;
                $role->bizrule     = $model->bizrule;
                $role->data        = $model->data;   
                
                $this->redirect($this->createUrl("manage"));        
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
        $this->protectSystemRoles($id);

	    Yii::app()->authManager->removeAuthItem($id);
	    
		if(!isset($_GET['ajax']))
        {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }	    
	}


	public function actionAssignment() 
	{	
		$model = User::model();

		if (isset($_POST['user_id']) && isset($_POST['role'])) 
		{
            AuthAssignment::updateUserRole($_POST['user_id'], $_POST['role']);

			Yii::app()->end();
		}		

		$this->render('assignment', array('model' => $model));
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


    private function protectSystemRoles($role)
    {
        if (!is_object($role))
        {
            $role = $this->loadModel($role);
        }

        if (in_array($role->name, AuthItem::$system_roles))
        {
            throw new CException('Нельзя редактировать у далять системные роли!');
        }
    }
}
