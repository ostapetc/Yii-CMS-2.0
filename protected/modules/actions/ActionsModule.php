<?php

class ActionsModule extends WebModule
{
    public static $active = false;


    public static function name()
    {
        return 'Мероприятия';
    }


    public static function description()
    {
        return 'Мероприятия клуба';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'actions.models.*',
			'actions.components.*',
		));
	}

    public static function adminMenu()
    {
        return array(
            'Все мероприятия'     => '/actions/ActionAdmin/manage',
            'Создать мероприятие' => '/actions/ActionAdmin/create'
        );
    }
}
