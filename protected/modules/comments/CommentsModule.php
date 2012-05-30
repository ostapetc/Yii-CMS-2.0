<?

class CommentsModule extends WebModule
{
	public static $active = true;


    public static function name()
    {
        return 'Комментарии';
    }


    public static function description()
    {
        return 'Комментарии';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'comments.models.*',
			'comments.portlets.*',
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
