<? echo "<?\n"; ?>

class <?= ucfirst($id); ?>Module extends WebModule
{
	public static $active = true;


    public static function name()
    {
        return '<?= $name ?>';
    }


    public static function description()
    {
        return '<?= $description ?>';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{
		$this->setImport(array(
			'<?= $id; ?>.models.*',
			'<?= $id; ?>.components.*',
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
