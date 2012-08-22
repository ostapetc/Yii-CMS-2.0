<?
class DocsModule extends WebModule
{
    public static $active = true;


    public function getName()
    {
        return 'Документациякода';
    }


    public function getDescription()
    {
        return 'Документация';
    }


    public function getVersion()
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

    public function routes()
    {
        return array(
            '/docs/module/<module:.*>/<view:.*>' => '/docs/docs/module',
            '/docs/<view:.*>' => '/docs/docs/index',
            '/docs/base/<view:.*>' => '/docs/docs/index',
            '/docs/base/<folder:\w*>/<view:\w*>' => '/docs/docs/index',
        );
    }


    public function adminMenu()
    {
        return array(
        );
    }
}
