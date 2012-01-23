<?php

class GeoModule extends WebModule
{	
	public static $active = true;
	
	
    public static function name()
    {
        return 'Локации';
    }


    public static function description()
    {
        return 'Страны и города';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'geo.models.*',
			'geo.components.*',
		));
	}

    public static function adminMenu()
    {
        return array(
            'Список стран'    => '/geo/countryAdmin/manage',
            'Добавить страну' => '/geo/countryAdmin/create',
            'Список городов'  => '/geo/cityAdmin/manage',
            'Добавить город'  => '/geo/cityAdmin/create'
        );
    }
}
