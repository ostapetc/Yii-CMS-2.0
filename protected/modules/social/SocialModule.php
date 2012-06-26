<?

class SocialModule extends WebModule
{
	public static $active = true;


    public static function name()
    {
        return '';
    }


    public static function description()
    {
        return '';
    }


    public static function version()
    {
        return '0.0';
    }


	public function init()
	{
		$this->setImport(array(
			'social.models.*',
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
