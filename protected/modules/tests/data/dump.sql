<?

class TestsModule extends WebModule
{
	public static $active = true;


    public static function name()
    {
        return 'testovi';
    }


    public static function description()
    {
        return 'desc';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'tests.models.*',
			'tests.components.*',
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
