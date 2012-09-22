<?php
/** 
 * 
 * !Attributes - атрибуты БД
 * @property integer         $allow_for_all
 * @property string          $name
 * @property integer         $type
 * @property string          $description
 * @property string          $bizrule
 * @property string          $data
 * 
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property                 $errorsFlatArray
 * @property                 $url
 * @property                 $updateUrl
 * @property                 $createUrl
 * @property                 $deleteUrl
 * 
 * !Relations - связи
 * @property AuthItemChild[] $childs
 * @property AuthItem[]      $operations
 * 
 * !Scopes - именованные группы условий, возвращают этот АР
 * @method   AuthItem        published()
 * @method   AuthItem        sitemap()
 * @method   AuthItem        ordered()
 * @method   AuthItem        last()
 * 
 */

class AuthItem extends ActiveRecord
{
    const SCENARIO_OPERATION = 'operation';
    const SCENARIO_TASK      = 'task';

    const ROLE_DEFAULT = 'user';
    const ROLE_GUEST   = 'guest';
    const ROLE_ROOT    = 'admin';


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
			    'pattern' => '/^[A-Za-z_0-9]+$/ui',
			    'message' => 'только латинский алфавит и нижнее подчеркивание и цифры'
			),
			array('type, allow_for_all', 'numerical', 'integerOnly' => true),
			array('name', 'length', 'max' => 64),
			array('description, bizrule, data', 'safe'),
            array('description', 'length', 'max' => 50),
			array('name, description', 'unique')
		);
	}


    public function relations()
    {
        return array(
            'childs' => array(
                self::HAS_MANY,
                'AuthItemChild',
                'parent'
            ),

            'operations' => array(
                self::HAS_MANY,
                'AuthItem',
                array('child' => 'name'),
                'through' => 'childs'
            )
        );
    }


    public static function constructName($controller, $action)
    {
        return ucfirst($controller) . '_' . ucfirst($action);
    }


    public function allowForRole($role_name)
    {
        $cauth_item_role = Yii::app()->authManager->getAuthItem($role_name);
        if ($cauth_item_role)
        {
            return $cauth_item_role->checkAccess($this->name);
        }
    }


//    public function actionExists()
//    {
//        list($controller, $action) = explode('_', $this->name);
//
//        $controller_class = $controller . 'Controller';
//        $controller_file  = $controller_class  . '.php';
//
//        $modules = Yii::app()->getModules();
//
//        foreach ($modules as $module)
//        {
//            $module_dir  = array_shift(explode('.', $module['class']));
//            $module_path = Yii::getPathOfAlias("application.modules.{$module_dir}");
//
//            $controllers_path = $module_path . DIRECTORY_SEPARATOR . 'controllers' .DIRECTORY_SEPARATOR;
//            if (!is_dir($controllers_path))
//            {
//                continue;
//            }
//
//            $controllers_files = scandir($controllers_path);
//
//            if (in_array($controller_file, $controllers_files))
//            {
//                require_once $controllers_path . $controller_file;
//
//                if (method_exists($controller_class, "action{$action}"))
//                {
//                    return true;
//                }
//                else
//                {
//                    return false;
//                }
//            }
//        }
//    }


//	public function getModulesWithActions()
//	{
//        $result = array();
//
//        $items = AuthItem::model()->findAllByAttributes(array("type" => AuthItem::TYPE_OPERATION));
//
//	    $modules = AppManager::getModulesData(true);
//	    foreach ($modules as $class => $data)
//	    {
//	        $actions = AppManager::getModuleActions($class);
//
//	        foreach ($items as $item)
//	        {
//	            if (isset($actions[$item->name]))
//	            {
//	                unset($actions[$item->name]);
//	            }
//	        }
//
//	        if ($actions)
//	        {
//	            $result[$class] = $data;
//	        }
//	    }
//
//        return $result;
//	}
}
