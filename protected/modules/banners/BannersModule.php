<?php

class BannersModule extends WebModule
{
    public static $active = true;


    public static function name()
    {
        return 'Баннеры';
    }


    public static function description()
    {
        return 'баннеры';
    }


    public static function version()
    {
        return '1.0';
    }


    public function init()
    {
        $this->setImport(array(
            'banners.models.*', 'banners.components.*',
        ));
    }


    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action))
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    public function getOperations()
    {
        return ArrayHelper::markObjects(Banner::model()->findAll(), 'name');
    }


    public static function adminMenu()
    {
        return array(
            'Баннеры (горизонт.)'   => '/banners/bannerAdmin/manage/is_big/1',
            'Баннеры (вертикаль.)'  => '/banners/bannerAdmin/manage/is_big/0',
            'Добавить (горизонт.)'  => '/banners/bannerAdmin/create/is_big/1',
            'Добавить (вертикаль.)' => '/banners/bannerAdmin/create/is_big/0',
        );
    }


}
