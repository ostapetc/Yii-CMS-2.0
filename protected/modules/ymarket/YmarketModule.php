<?php

class YmarketModule extends WebModule
{
    const YANDEX_MARKET_WEB_URL = "http://market.yandex.ru";

	public static $active = true;


    public static function name()
    {
        return 'Яндекс маркет';
    }


    public static function description()
    {
        return 'Парсит товары с Яндекс маркета';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'ymarket.models.*',
			'ymarket.components.*',
		));
	}

    public static function adminMenu()
    {
        return array(
            'Продукты'          => '/ymarket/ymarketProductAdmin/manage',
            'Бренды'            => '/ymarket/ymarketBrandAdmin/manage',
            'Разделы'           => '/ymarket/ymarketSectionAdmin/manage',
            'Добавить раздел'   => '/ymarket/ymarketSectionAdmin/create',
            'IP адреса'         => '/ymarket/ymarketIPAdmin/manage',
            'Добавить IP адрес' => '/ymarket/ymarketIPAdmin/create',
            'Фоновые задачи'    => '/ymarket/ymarketCronAdmin/manage'
        );
    }
}
