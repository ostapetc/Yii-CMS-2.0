<?php

class Setting extends ActiveRecordModel
{
    const PAGE_SIZE = 10;

    const ELEMENT_TEXTAREA = 'textarea';
    const ELEMENT_EDITOR   = 'editor';
    const ELEMENT_TEXT     = 'text';

    const FILES_DIR = '/upload/settings/';


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
			array('code, name, element','required'),
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
        if ($module_id)
        {
            $settings = $this->findAll("module_id = '{$module_id}'");
        }
        else
        {
            $settings = $this->findAll();
        }

        $result   = array();

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
            if ($setting->element == 'file')
            {
                return $setting->getFilePath();
            }

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


    public function getFormatedValue()
    {
        switch ($this->element)
        {
            case 'checkbox':
                return $this->value ? "Да" :"Нет";
                break;

            case 'file':
                if ($path = $this->getFilePath())
                {
                    return CHtml::image($path, '', array('height' => 20));
                }
                break;
        }

        return $this->value;
    }


    public function getFilePath()
    {
        if ($this->value && file_exists($_SERVER['DOCUMENT_ROOT'] . self::FILES_DIR . $this->value))
        {
            return self::FILES_DIR . $this->value;
        }
    }


    public function uploadFiles()
    {
        if ($this->element == 'file')
        {
            if (!is_dir($_SERVER['DOCUMENT_ROOT'] . self::FILES_DIR))
            {
                mkdir($_SERVER['DOCUMENT_ROOT'] . self::FILES_DIR, 0777, true);
                chmod($_SERVER['DOCUMENT_ROOT'] . self::FILES_DIR, 0777);
            }

            return array(
                'value' => array(
                    'dir' => self::FILES_DIR
                )
            );
        }

        return array();
    }
}