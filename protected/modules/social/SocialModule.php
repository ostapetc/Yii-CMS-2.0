<?

class SocialModule extends WebModule
{
	public static $active = true;

    public $icon = 'user';

    public function getName()
    {
        return '';
    }


    public function getDescription()
    {
        return '';
    }


    public function getVersion()
    {
        return '0.0';
    }


	public function init()
	{
		$this->setImport(array(
			'social.models.*',
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
