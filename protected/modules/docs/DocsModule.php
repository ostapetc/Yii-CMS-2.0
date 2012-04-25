<?
class DocsModule extends WebModule
{
    public static $active = false;


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


    public static function adminMenu()
    {
        return array(
        );
    }
}
