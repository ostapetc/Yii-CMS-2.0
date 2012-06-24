<?

class VideoModule extends WebModule
{
	public static $active = true;


    public static function name()
    {
        return 'Видео';
    }


    public static function description()
    {
        return 'Видео хостинг агрегатор';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'video.models.*',
			'video.portlets.*',
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
