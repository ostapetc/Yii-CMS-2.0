<?

class TagsModule extends WebModule
{
	public static $active = true;


    public static function name()
    {
        return 'Теги';
    }


    public static function description()
    {
        return 'Тегирование';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'tags.models.*',
			'tags.portlets.*',
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
