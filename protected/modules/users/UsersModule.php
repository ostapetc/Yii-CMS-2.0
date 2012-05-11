<?

class UsersModule extends WebModule
{
    const MAILER_TEMPLATE_REGISTRATION = 'user_registration';

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
            'Все пользователи '     => '/users/userAdmin/manage',
            'Добавить пользователя' => '/users/userAdmin/create',
        );
    }


    public static function routes()
    {
        return array(
            '/admin/login/*'                        => 'users/userAdmin/login',
            '/login'                                => 'users/user/login',
            '/logout'                               => 'users/user/logout',
            '/logout'                               => 'users/user/logout',
            '/registration'                         => 'users/user/registration',
            '/activateAccount/<code:.*>'            => 'users/user/activateAccount',
            '/activateAccountRequest'               => 'users/user/activateAccountRequest',
            '/changePasswordRequest'                => 'users/user/changePasswordRequest',
            '/changePassword/<code:.*>/<email:.*>'  => 'users/user/changePassword',
        );
    }
}
