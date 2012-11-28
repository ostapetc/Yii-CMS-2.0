<?

class MMaModule extends WebModule
{
	public static $active = true;


    public static function name()
    {
        return 'Единоборства';
    }


    public static function description()
    {
        return 'Единоборства';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'mma.models.*',
		));
	}


    public function adminMenu()
    {
        return array(
        );
    }


    public function routes()
    {
        return array(
            '/fighters' => '/mma/fighter/index'
        );
    }
}
