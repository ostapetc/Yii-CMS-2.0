<?

class RbacModule extends WebModule
{	
	public static $active = true;

    public $icon = 'eye-open';

    public function getName()
    {
        return 'Контроль доступа';
    }


    public function getDescription()
    {
        return 'Система контроля доступа на основе ролей';
    }


    public function getVersion()
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


    public function adminMenu()
    {
        return array(
            'Роли'              => '/rbac/RoleAdmin/manage',
            'Операции и задачи' => '/rbac/TaskAdmin/manage'
        );
    }


    public static function isAllow($auth_item)
    {
        return true;
    }
}
