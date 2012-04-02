<?

class TestModule extends WebModule
{	
	public static $active = false;


    public static function name()
    {
        return 'test';
    }


    public static function description()
    {
        return 'test';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'test.models.*',
			'test.components.*',
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
        );
    }
}
