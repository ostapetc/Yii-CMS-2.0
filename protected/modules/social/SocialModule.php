<?

class SocialModule extends WebModule
{
	public static $active = true;


    public static function name()
    {
        return 'Социальность';
    }


    public static function description()
    {
        return 'Социальность';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'social.models.*',
			'social.portlets.*',
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
