<?

class UsersModule extends WebModule
{
    const MAILER_TEMPLATE_REGISTRATION    = 'user_registration';
    const MAILER_TEMPLATE_ACTIVATION      = 'user_activation';
    const MAILER_TEMPLATE_CHANGE_PASSWORD = 'user_change_password';

    const PARAM_REGISTRATION_DONE_MESSAGE = 'registration_done_message';

	public static $active = true;

    public static $base_module = true;


    public static function name()
    {
        return 'Пользователи';
    }


    public static function description()
    {
        return 'Пользователи, права доступа';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'users.models.*',
			'users.components.*',
		));
	}


    public static function adminMenu()
    {
        return array(
            'Все пользователи '     => Yii::app()->createUrl('/users/userAdmin/manage'),
            'Добавить пользователя' => Yii::app()->createUrl('/users/userAdmin/create'),
        );
    }


    public static function routes()
    {
        return array(
            '/admin/login/*'             => 'users/userAdmin/login',
            '/login'                     => 'users/user/login',
            '/user/<id:\d*>'             => 'users/user/view',
            '/logout'                    => 'users/user/logout',
            '/registration'              => 'users/user/registration',
            '/activateAccount/<code:.*>' => 'users/user/activateAccount',
            '/activateAccountRequest'    => 'users/user/activateAccountRequest',
            '/changePasswordRequest'     => 'users/user/changePasswordRequest',
            '/changePassword/<code:.*>'  => 'users/user/changePassword',
        );
    }
}
