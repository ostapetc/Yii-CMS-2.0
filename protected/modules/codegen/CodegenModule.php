<?
class CodegenModule extends WebModule
{
    public static $active = true;


    public function getName()
    {
        return 'Генератор кода';
    }


    public function getDescription()
    {
        return 'Генератор кода';
    }


    public function getVersion()
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


    public function adminMenu()
    {
        return array(
            'Создать модуль' => Yii::app()->createUrl('/codegen/moduleAdmin/create'),
            'Создать модель' => Yii::app()->createUrl('/codegen/modelAdmin/create'),
            'Создать форму'  => Yii::app()->createUrl('/codegen/formAdmin/create'),
            'Создать CRUD'   => Yii::app()->createUrl('/codegen/crudAdmin/create'),
        );
    }
}
