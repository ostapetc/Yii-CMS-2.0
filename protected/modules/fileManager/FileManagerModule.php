<?php
class FileManagerModule extends WebModule
{
    public static $active = false;

    public function init()
    {
        $this->setImport(array(
            'fileManager.components.*',
            'fileManager.models.*'
        ));
    }


    public static function name()
    {
        return 'Файловый менеджер';
    }


    public static function description()
    {
        return 'Добавляет возможность использования HTML5 загрузчика. Используется для создания своих модулей.';
    }


    public static function version()
    {
        return '2.0';
    }


    public static function adminMenu()
    {
        return array(
            "Все файлы" => "/fileManager/fileManagerAdmin/manage"
        );
    }
}