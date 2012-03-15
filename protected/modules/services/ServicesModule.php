<?php

class ServicesModule extends WebModule
{
    public static $active = false;

    public static function name()
    {
        return 'Вебсервисы';
    }


    public static function description()
    {
        return 'Вебсервисы сайта';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'services.models.*',
			'services.components.*',
		));
	}


    public static function adminMenu()
    {
        return array(
			'JsonRpcApi' => '/services/api/json',
			'SoapApi'    => '/services/api/soap'
        );
    }

}
