<?php

class ImpexModule extends WebModule
{
    public static $active = false;


    public static function name()
    {
        return '';
    }


    public static function description()
    {
        return '';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'impex.models.*',
			'impex.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		else
        {
            return false;
        }
	}


    public static function adminMenu()
    {
        return array(
            array(
                'Управление',
                '//Admin/manage',
                '//Admin/create'
            )
        );
    }
}
