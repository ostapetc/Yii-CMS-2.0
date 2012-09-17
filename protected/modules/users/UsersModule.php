<?

class UsersModule extends WebModule
{
    const MAILER_TEMPLATE_REGISTRATION    = 'user_registration';
    const MAILER_TEMPLATE_ACTIVATION      = 'user_activation';
    const MAILER_TEMPLATE_CHANGE_PASSWORD = 'user_change_password';

    const PARAM_REGISTRATION_DONE_MESSAGE = 'registration_done_message';

	public static $active = true;

    public static $base_module = true;

//    public $icon = ;


    public function getName()
    {
        return 'Пользователи';
    }


    public function getDescription()
    {
        return 'Пользователи, права доступа';
    }


    public function getVersion()
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


    public function adminMenu()
    {
        return array(
            'Все пользователи '     => '/users/userAdmin/manage',
            'Добавить пользователя' => '/users/userAdmin/create',
        );
    }


    public function routes()
    {
        return array(
            '/admin/login/*'             => 'users/userAdmin/login',
            '/login'                     => 'users/user/login',
            '/user/<id:\d*>'             => 'users/user/view',
            '/user/updateSelfData'       => 'users/user/updateSelfData',
            '/logout'                    => 'users/user/logout',
            '/registration'              => 'users/user/registration',
            '/activateAccount/<code:.*>' => 'users/user/activateAccount',
            '/activateAccountRequest'    => 'users/user/activateAccountRequest',
            '/changePasswordRequest'     => 'users/user/changePasswordRequest',
            '/changePassword/<code:.*>'  => 'users/user/changePassword',
            '/users'                      => '/users/user/index'
        );
    }
}
