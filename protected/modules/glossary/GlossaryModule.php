<?php

class GlossaryModule extends WebModule
{
    public static $active = true;
    
    public static function name()
    {
        return 'Глоссарий';
    }


    public static function description()
    {
        return 'Статьи прессы';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'glossary.models.*',
			'glossary.components.*',
            'glossary.components.alphapager.*'
		));
	}

    public static function adminMenu()
    {
        return array(
			'Все статьи'      => '/glossary/glossaryAdmin/manage/Glossary_sort/date.desc',
			'Добавить статью' => '/glossary/glossaryAdmin/create'
        );
    }

    public static function urlRules()
    {
        return array(
            '<lang:[a-z]{2}>/press/<id:\d+>' => 'press/press/view',
            '<lang:[a-z]{2}>/press'          => 'press/press/index',
        );
    }
}
