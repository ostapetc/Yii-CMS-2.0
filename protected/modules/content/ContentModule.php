<?php

class ContentModule extends WebModule
{
    public static function name()
    {
        return 'Контент';
    }


    public static function description()
    {
        return 'Свободно редактируемые страницы, контентные блоки, меню сайта';
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
        return array(
            'Список страниц'    => '/content/pageAdmin/manage',
            'Добавить страницу' => '/content/pageAdmin/create',
            'Блоки страниц'     => '/content/pageBlockAdmin/manage',
            'Добавить блок'     => '/content/pageBlockAdmin/create',
            'Управление меню'   => '/content/menuAdmin/manage',
            'Добавить меню'     => '/content/menuAdmin/create'
        );
    }
}
