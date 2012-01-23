<?php

class UsersModule extends WebModule
{
	public static $active = true;
		
	
    public static $base_module = true;


    public static function name()
    {
        return 'Пользователи';
    }


    public static function description()
    {
        return 'Пользователи, права доступа';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'users.models.*',
			'users.components.*',
		));
	}


    public static function adminMenu()
    {
        return array(
            'Все пользователи '     => '/users/userAdmin/manage',
            'Добавить пользователя' => '/users/userAdmin/create',
        );
    }
}
