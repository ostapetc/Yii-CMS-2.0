<?

class SocialModule extends WebModule
{
	public static $active = true;

    public $icon = 'user';

    public function getName()
    {
        return 'Социальность';
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
            '/friends/<user_id:\d+>' => '/social/friend/index',
            '/friends/<user_id:\d+>/<type:in|out>' => '/social/friend/index',
            '/messages/<user_id:\d+>' => 'social/message/index/'
        );
    }
}
