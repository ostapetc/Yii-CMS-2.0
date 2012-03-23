<?php

class FeedbackModule extends WebModule
{	
	public static $active = true;


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
			'feedback.models.*',
			'feedback.components.*',
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
            'Полученные сообщения' => '/feedback/feedbackAdmin/manage',
            'Список тем'           => '/feedback/feedbackTopicAdmin/manage',
            'Добавить тему'        => '/feedback/feedbackTopicAdmin/create',
        );
    }
}
