<? echo "<?\n"; ?>

class <? echo $this->moduleClass; ?> extends WebModule
{	
	public static $active = false;


    public static function name()
    {
        return '<? echo $this->name; ?>';
    }


    public static function description()
    {
        return '<? echo $this->description; ?>';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'<? echo $this->moduleID; ?>.models.*',
			'<? echo $this->moduleID; ?>.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		else
        {
            return false;
        }
	}


    public static function adminMenu()
    {
        return array(
        );
    }
}
