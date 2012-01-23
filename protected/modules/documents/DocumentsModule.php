<?php

class DocumentsModule extends WebModule
{	
	public static $active = false;
	
	
    public static function name()
    {
        return 'Уставные документы клуба';
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
			'documents.models.*',
			'documents.components.*',
		));
	}



    public static function adminMenu()
    {
        return array(
        	'Все документы'     => '/documents/DocumentAdmin/manage',
        	'Добавить документ' => '/documents/DocumentAdmin/create'
        );
    }
}
