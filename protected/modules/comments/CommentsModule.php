<?

class CommentsModule extends WebModule
{
	public static $active = true;

    public $icon = 'comment';

    public function getName()
    {
        return 'Комментарии';
    }


    public function getDescription()
    {
        return 'Комментарии';
    }


    public function getVersion()
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
