<?php

class FaqModule extends WebModule
{	
	public static $active = true;
	
	
    public static function name()
    {
        return 'Вопрос ответ';
    }


    public static function description()
    {
        return 'Вопросы и ответы, древовидные разделы';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'faq.models.*',
			'faq.components.*',
		));
	}

    public static function adminMenu()
    {
        return array(
            'Все вопросы и ответы'    => '/faq/faqAdmin/manage',
            'Добавить вопрос и ответ' => '/faq/faqAdmin/create',
            'Список разделов'         => '/faq/faqSectionAdmin/manage',
            'Добавить раздел'         => '/faq/faqSectionAdmin/create'
        );
    }
}
