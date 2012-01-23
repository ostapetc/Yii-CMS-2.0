<?php

class Setting extends ActiveRecordModel
{
    const PAGE_SIZE = 10;

    const ELEMENT_TEXTAREA = 'textarea';
    const ELEMENT_EDITOR   = 'editor';
    const ELEMENT_TEXT     = 'text';
   

    public static $elements = array(
        self::ELEMENT_TEXT     => "Строка",
        self::ELEMENT_TEXTAREA => "Текст",
        self::ELEMENT_EDITOR   => "Редактор"
    );


    public function name()
    {
        return 'Настройки';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'settings';
	}


	public function rules()
	{
		return array(
			array('code, name, value, element','required'),
			array('code', 'length', 'max'=>50),
			array('name', 'length', 'max'=>100),
			array('element', 'length', 'max'=>8),
			array('hidden', 'numerical', 'integerOnly' => true),
            array('value', 'safe'), 
			array('id, code, name, element', 'safe', 'on'=>'search')
		);
	}


	public function search($module_id = null)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('element',$this->element,true);

        if ($module_id)
        {
            $criteria->compare('module_id', $module_id);
        }

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public function findCodesValues($module_id = null)
    {
    	if (!$module_id) 
    	{
    		$module_id = Yii::app()->controller->module->id;
    	}
    	
        $result = array();

        $settings = $this->findAll("module_id = '{$module_id}'");
        foreach ($settings as $setting)
        {
            $result[$setting->code] = $setting->value;
        }

        return $result;
    }


    public static function getValue($code)
    {
        $setting = self::model()->findByAttributes(array('code' => $code));
        if ($setting)
        {
            return $setting->value;
        }
    }


    public static function checkRequired($codes, $module_id = null)
    {
        $settings = self::model()->findCodesValues($module_id);

        foreach ($codes as $code)
        {
            if (!array_key_exists($code, $settings))
            {
                throw new Exception('Не найдена обязательная настройка: ' . $code);
            }
        }
    }
}