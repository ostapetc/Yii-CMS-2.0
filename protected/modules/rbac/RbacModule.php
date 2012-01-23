<?php

class RbacModule extends WebModule
{	
	public static $active = true;


    public static function name()
    {
        return 'Контроль доступа';
    }


    public static function description()
    {
        return 'Система контроля доступа на основе ролей';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{   
		$this->setImport(array(
			'rbac.models.*',
            'rbac.controllers.*',
			'rbac.components.*',
		));
	}


    public static function adminMenu()
    {
        return array(
            'Роли'              => '/rbac/RoleAdmin/manage',
			'Назначение ролей'  => '/rbac/RoleAdmin/assignment',
        	'Добавить роль'     => '/rbac/RoleAdmin/create',
        	'Операции'          => '/rbac/OperationAdmin/manage',
        	'Добавить операцию' => '/rbac/OperationAdmin/create',
        	'Задачи'            => '/rbac/TaskAdmin/manage',
        	'Добавить задачу'   => '/rbac/TaskAdmin/create'        	
        );
    }


    public static function isAllow($item_name)
    {
        if (isset(Yii::app()->user->role) && Yii::app()->user->role == AuthItem::ROLE_ROOT)
        {
            return true;
        }

        $auth_item = AuthItem::model()->findByPk($item_name);

        if (!$auth_item)
        {
            Yii::log('Задача $item_name не найдена!');
            return false;
        }

        if ($auth_item->allow_for_all)
        {
            return true;
        }

        if ($auth_item->tasks)
        {
            foreach ($auth_item->tasks as $task)
            {
                if ($task->allow_for_all)
                {
                    return true;
                }
                elseif (Yii::app()->user->checkAccess($task->name))
                {
                    return true;
                }
            }
        }
        else
        {
            if (Yii::app()->user->checkAccess($auth_item->name))
            {
                return true;
            }
        }

        return false;
    }
}
