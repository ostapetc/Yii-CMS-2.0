<?

class RbacModule extends WebModule
{	
	public static $active = true;


    public static function name()
    {
        return 'Контроль доступа';
    }


    public static function description()
    {
        return 'Система контроля доступа на основе ролей';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'rbac.models.*',
            'rbac.controllers.*',
			'rbac.components.*',
		));
	}


    public static function adminMenu()
    {
        return array(
            'Роли' => '/rbac/RoleAdmin/manage',
        );
    }


    public static function isAllow($auth_item)
    {
        return true;
    }
}
