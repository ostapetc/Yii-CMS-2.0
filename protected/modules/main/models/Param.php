<?

class Param extends ActiveRecord
{
    const PAGE_SIZE = 10;

    const FILES_DIR = '/upload/params/';

    const SCENARIO_VALUE_UPDATE = 'value_update';

    const OPTION_NAME_VALUE_SEPARATOR = '=';

    const ELEMENT_TEXTAREA = 'textarea';
    const ELEMENT_EDITOR   = 'editor';
    const ELEMENT_TEXT     = 'text';
    const ELEMENT_CHECKBOX = 'checkbox';
    const ELEMENT_FILE     = 'file';
    const ELEMENT_SELECT   = 'select';


    public static $elements = array(
        self::ELEMENT_TEXT     => 'Строка',
        self::ELEMENT_TEXTAREA => 'Текст',
        self::ELEMENT_EDITOR   => 'Редактор',
        self::ELEMENT_CHECKBOX => 'Галочка',
        self::ELEMENT_FILE     => 'Файл',
        self::ELEMENT_SELECT   => 'Выпадающий список'
    );


    public function name()
    {
        return 'Параметры';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'params';
	}


	public function rules()
	{
		return array(
			array('code, name','required'),
            array('module_id', 'required', 'on' => array(self::SCENARIO_CREATE, self::SCENARIO_UPDATE)),
			array('code', 'length', 'max'=>50),
			array('name', 'length', 'max'=>100),
			array('element', 'length', 'max'=>8),
            array('element', 'in', 'range' => self::$elements),
            array('value', 'safe'),
            array('options', 'optionsValidator'),
            array('element', 'safe', 'on' => array(self::SCENARIO_CREATE, self::SCENARIO_UPDATE)),
		);
	}


    public function optionsValidator($attribute)
    {
        if ($this->element != self::ELEMENT_SELECT)
        {
            return;
        }

        if (empty($this->options))
        {
            $this->addError($attribute, 'Введите список значений!');
            return;
        }

        $options = explode("\n", $this->$attribute);
        foreach ($options as $option)
        {
            $option = trim($option);

            if (!empty($option) && !preg_match('|^.*' . self::OPTION_NAME_VALUE_SEPARATOR . '.*$|', $option))
            {
                $this->addError($attribute, 'неверный формат');
                return;
            }
        }
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


    public static function get($code)
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


    public static function getValue($code)
    {
        return self::get($code);
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
                    return CHtml::link($this->value, $path, array('target' => '_blank'));
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
                    'dir'        => self::FILES_DIR,
                    'hash_store' => false
                )
            );
        }

        return array();
    }


    public function beforeSave()
    {
        $options = array();

        foreach (explode("\n", $this->options) as $i => $string)
        {
            $string = trim($string);

            if (!empty($string))
            {
                $options[] = $string;
            }
        }

        $this->options = implode("\n", $options);

        return parent::beforeSave();
    }
}