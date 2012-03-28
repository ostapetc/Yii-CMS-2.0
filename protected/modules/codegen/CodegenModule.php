<?
class CodegenModule extends WebModule
{
    public static $active = true;


    public static function name()
    {
        return 'Генератор кода';
    }


    public static function description()
    {
        return 'Генератор кода';
    }


    public static function version()
    {
        return '1.0';
    }


	public function init()
	{

		$this->setImport(array(
			'codegen.models.*',
			'codegen.portlets.*',
		));
	}


    public static function adminMenu()
    {
        return array(
            'Добавить модель' => Yii::app()->createUrl('/codegen/modelAdmin/create'),
        );
    }
}
