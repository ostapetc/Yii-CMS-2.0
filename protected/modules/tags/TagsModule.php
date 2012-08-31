<?

class TagsModule extends WebModule
{
	public static $active = true;


    public function getName()
    {
        return 'Теги';
    }


    public function getDescription()
    {
        return 'Тегирование';
    }


    public function getVersion()
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
