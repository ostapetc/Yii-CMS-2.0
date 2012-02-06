<?php

class DocsModule extends WebModule
{
    public static function name()
    {
        return 'Документация';
    }


    public static function description()
    {
        return 'Документация CMF';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'content.models.*',
			'content.portlets.*',
		));
	}


    public static function adminMenu()
    {
        return array();
    }
}
