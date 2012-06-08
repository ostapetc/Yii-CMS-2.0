<?

class RatingModule extends WebModule
{
	public static $active = true;


    public static function name()
    {
        return 'Рейтинг';
    }


    public static function description()
    {
        return 'Рейтинг';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'rating.models.*',
			'rating.portlets.*',
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
