<?
class DocsModule extends WebModule
{
    public static $active = true;


    public static function name()
    {
        return 'Документациякода';
    }


    public static function description()
    {
        return 'Документация';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'docs.models.*',
			'docs.portlets.*',
		));
	}

    public static function routes()
    {
        return array(
            '/docs/module/<module:.*>/<view:.*>' => '/docs/mark/module',
            '/docs/<view:.*>' => '/docs/mark/index',
            '/docs/base/<view:.*>' => '/docs/mark/index',
            '/docs/base/<folder:\w*>/<view:\w*>' => '/docs/mark/index',
        );
    }


    public static function adminMenu()
    {
        return array(
        );
    }
}
