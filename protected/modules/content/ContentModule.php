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
            'Список страниц'    => Yii::app()->createUrl('/content/pageAdmin/manage'),
            'Добавить страницу' => '/content/pageAdmin/create',
            'Управление меню'   => '/content/menuAdmin/manage',
            'Добавить меню'     => '/content/menuAdmin/create',
        );
    }


    public static function routes()
    {
        $routes = array(
            '/page/<id:\d+>' => 'content/page/view',
            '/page/<url:.*>' => 'content/page/view',
            '/search'        => 'content/page/search'
        );

        foreach (array_keys(Language::getCachedArray()) as $language)
        {
            $routes["/"] = 'content/page/main';
        }

        return $routes;
    }
}
