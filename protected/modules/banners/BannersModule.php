<?php

class BannersModule extends WebModule
{
    public static $active = true;
    public $icon = 'th-large';


    public function getName()
    {
        return 'Баннеры';
    }


    public function getDescription()
    {
        return 'баннеры';
    }


    public function getVersion()
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


    public function adminMenu()
    {
        return array(
            'Баннеры (горизонт.)'   => '/banners/bannerAdmin/manage/is_big/1',
            'Баннеры (вертикаль.)'  => '/banners/bannerAdmin/manage/is_big/0',
            'Добавить (горизонт.)'  => '/banners/bannerAdmin/create/is_big/1',
            'Добавить (вертикаль.)' => '/banners/bannerAdmin/create/is_big/0',
        );
    }




}
