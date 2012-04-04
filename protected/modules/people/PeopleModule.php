<?

class PeopleModule extends WebModule
{
	public static $active = true;


    public static function name()
    {
        return 'People name';
    }


    public static function description()
    {
        return 'People description';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'People.models.*',
			'People.components.*',
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
