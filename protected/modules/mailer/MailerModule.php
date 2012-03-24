<?php

class MailerModule extends WebModule
{	
	public static $active = true;


    public static function name()
    {
        return 'Рассылка';
    }


    public static function description()
    {
        return 'Email рассылка';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'mailer.models.*',
			'mailer.components.*',
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
            'Исходящие письма' => Yii::app()->createUrl('/mailer/outboxEmailAdmin/manage')
        );
    }
}
