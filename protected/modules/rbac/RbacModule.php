<?php

class RbacModule extends WebModule
{	
	public static $active = false;


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
}
