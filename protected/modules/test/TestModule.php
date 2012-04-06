<?

class TestModule extends WebModule
{
	public static $active = true;


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


    public static function adminMenu()
    {
        return array(
        );
    }


    public static function routes()
    {
        return array(
        );
    }
}
