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


    public function getName()
    {
        return 'Рассылка';
    }


    public function getDescription()
    {
        return 'Email рассылка';
    }


    public function getVersion()
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


    public function adminMenu()
    {
        return array(
            'Исходящие письма' => Yii::app()->createUrl('/mailer/mailerOutboxAdmin/manage'),
            'Шаблоны'          => Yii::app()->createUrl('/mailer/mailerTemplateAdmin/manage'),
            'Добавить шаблон'  => Yii::app()->createUrl('/mailer/mailerTemplateAdmin/create'),
        );
    }
}
