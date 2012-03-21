<?php

class ServicesModule extends WebModule
{	
	public static $active = true;


    public static function name()
    {
        return 'Услуги';
    }


    public static function description()
    {
        return 'Услуги, товары, заказы';
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
            'Управление продуктами' => Yii::app()->createUrl('services/productAdmin/manage'),
            'Добавить продукт'      => Yii::app()->createUrl('services/productAdmin/create'),
            'Управление заказами'   => Yii::app()->createUrl('services/orderAdmin/manage'),
        );
    }
}
