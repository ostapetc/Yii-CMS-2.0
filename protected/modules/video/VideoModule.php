<?

class VideoModule extends WebModule
{
	public static $active = true;


    public function getName()
    {
        return 'Видео';
    }


    public function getDescription()
    {
        return 'Видео хостинг агрегатор';
    }


    public function getVersion()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'video.models.*',
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
        );
    }
}
