<?

class MailerModule extends WebModule
{
    const PARAM_REPLY_EMAIL = 'reply_email';
    const PARAM_FROM_EMAIL  = 'from_email';
    const PARAM_FROM_NAME   = 'from_name';
    const PARAM_PASSWORD    = 'password';
    const PARAM_LOGIN       = 'login';
    const PARAM_HOST        = 'host';
    const PARAM_PORT        = 'port';


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
            'Исходящие письма' => Yii::app()->createUrl('/mailer/mailerOutboxAdmin/manage'),
            'Шаблоны'          => Yii::app()->createUrl('/mailer/mailerTemplateAdmin/manage'),
            'Добавить шаблон'  => Yii::app()->createUrl('/mailer/mailerTemplateAdmin/create'),
        );
    }
}
