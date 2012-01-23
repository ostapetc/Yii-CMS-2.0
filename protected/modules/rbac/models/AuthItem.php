<?php

class AuthItem extends ActiveRecordModel
{
    const PAGE_SIZE = 10;

	const PHOTOS_DIR = 'upload/news';

	const ROLE_DEFAULT = 'user';
    const ROLE_GUEST   = 'guest';
    const ROLE_ROOT    = 'admin';

    const TYPE_OPERATION = 0;
    const TYPE_TASK      = 1;    
    const TYPE_ROLE      = 2;

	public $module;

    public $parent;

	public static $system_roles = array(
        self::ROLE_DEFAULT,
        self::ROLE_GUEST,
        self::ROLE_ROOT
    );


    public function name()
    {
        return 'Элементы авторизации';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'auth_items';
	}


	public function rules()
	{
		return array(
			array('name, description', 'required'),
			array(
			    'name', 
			    'match', 
			    'pattern' => '/^[A-Za-z_]+$/ui', 
			    'message' => 'только латинский алфавит и нижнее подчеркивание'
			),
			array('type, allow_for_all', 'numerical', 'integerOnly' => true),
			array('name', 'length', 'max' => 64),
			array('description, bizrule, data', 'safe'),
			array('name', 'TypeUnique'),
			array('name, type, description, bizrule, data', 'safe', 'on' => 'search'),
		);
	}
	
	
	public function typeUnique($attr) 
	{  
		$exist = $this->findByAttributes(array('type' => $this->type, 'name' => $this->$attr));	
		if ($exist) 
		{   
		    if ($exist->primaryKey != $this->primaryKey) 
		    {
		        $this->addError($attr, 'Данное имя уже занято!');
		    }	
		}
	}


	public function relations()
	{
		return array(
		    'operations' => array(
                self::MANY_MANY,
                'AuthItem',
                'auth_items_childs(parent, child)',
                'condition' => 'type = "' . self::TYPE_OPERATION . '"'
            ),
            'tasks' => array(
                self::MANY_MANY,
                'AuthItem',
                'auth_items_childs(parent, child)',
                'condition' => 'type = "' . self::TYPE_TASK . '"'
            ),
            'assignments' => array(self::HAS_MANY, 'AuthAssignment', 'itemname'),
            'users'       => array(self::HAS_MANY, 'User', 'userid', 'through' => 'assignments')
		);
	}


    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['operations'] = 'Операции';
        $labels['tasks'] = 'Задачи';

        return $labels;
    }


    public function getTask()
    {
        $subtable = AuthItemChild::model()->tableName();
        $sql = "SELECT * FROM {$this->tableName()}
                         WHERE name = (SELECT parent FROM {$subtable} WHERE child = '" . $this->name . "')";

        return $this->findBySql($sql);
    }


	public function search($type)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('name', $this->name, true);
		$criteria->compare('type', $this->type);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('bizrule', $this->bizrule, true);
		$criteria->compare('data', $this->data, true);
        $criteria->addCondition('type = ' . $type);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}

	
	public function getModulesWithActions() 
	{
        $result = array();
        
        $items = AuthItem::model()->findAllByAttributes(array("type" => AuthItem::TYPE_OPERATION));
        
	    $modules = AppManager::getModulesData(true);
	    foreach ($modules as $class => $data) 
	    {
	        $actions = AppManager::getModuleActions($class);
	        
	        foreach ($items as $item) 
	        {
	            if (isset($actions[$item->name])) 
	            {
	                unset($actions[$item->name]); 
	            }
	        }
	        
	        if ($actions) 
	        {
	            $result[$class] = $data;
	        }
	    }         
	
        return $result;  
	}
	

    public static function constructName($controller, $action)
    {
        return ucfirst($controller) . '_' . ucfirst($action);
    }


    public function getRoles()
    {
        return $this->findAllByAttributes(array(
            'type' => self::TYPE_ROLE
        ));
    }


    public function actionExists()
    {
        list($controller, $action) = explode('_', $this->name);

        $controller_class = $controller . 'Controller';
        $controller_file  = $controller_class  . '.php';

        $modules = Yii::app()->getModules();

        foreach ($modules as $module)
        {
            $module_dir  = array_shift(explode('.', $module['class']));
            $module_path = Yii::getPathOfAlias("application.modules.{$module_dir}");

            $controllers_path = $module_path . DIRECTORY_SEPARATOR . 'controllers' .DIRECTORY_SEPARATOR;
            if (!is_dir($controllers_path))
            {
                continue;
            }

            $controllers_files = scandir($controllers_path);
            
            if (in_array($controller_file, $controllers_files))
            {
                require_once $controllers_path . $controller_file;

                if (method_exists($controller_class, "action{$action}"))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
    }
}
