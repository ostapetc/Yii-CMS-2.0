<?php

class FeetbackModule extends WebModule
{
    public static $active = false;


    public static function name()
    {
        return 'Обратная связь';
    }


    public static function description()
    {
        return 'Обратная связь';
    }


    public static function version()
    {
        return '1.0';
    }


    public function init()
    {
        $this->setImport(array(
            'feedback.models.*', 'feedback.components.*',
        ));
    }


    public static function adminMenu()
    {
        return array(
            'Все письма'      => '/feedback/feedbackAdmin/manage',
            'Добавить письмо' => '/feedback/feedbackAdmin/create',
            'Список разделов' => '/feedback/feedbackSectionAdmin/manage',
            'Добавить раздел' => '/feedback/feedbackSectionAdmin/create'
        );
    }
}
