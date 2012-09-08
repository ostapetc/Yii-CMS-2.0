<?

class AppManager
{
    private static $_modules_client_menu;

    private static $pathAliaces = array(
        'gridColumns' => 'application.components.zii.gridColumns',
        'bootstrap' => 'application.components.bootstrap'
    );


    public static function init()
    {
        //init PathOfAliaces
        foreach (self::$pathAliaces as $short => $full)
        {
            Yii::setPathOfAlias($short, Yii::getPathOfAlias($full));
        }

        //init modules
        foreach (Yii::app()->getModules() as $module => $config)
        {
            Yii::app()->getModule($module);
        }

        Yii::app()->urlManager->collectRules();
    }


    public static function getModulesData($active = null, $check_allowed_links = false)
    {
        $modules = array();
        foreach (Yii::app()->getModules() as $module_id => $module_config)
        {
            $module       = Yii::app()->getModule($module_id);
            $module_class = get_class($module);
            $vars         = get_class_vars($module_class);

            if (!$vars || !isset($vars['active']) || !$vars['active'])
            {
                continue;
            }

            $moduleInfo = array(
                'description' => $module->getDescription(),
                'version'     => $module->getVersion(),
                'name'        => $module->getName(),
                'icon'        => $module->icon,
                'class'       => $module_class,
                'dir'         => $module_id
            );

            //че за фигня?
            //if (method_exists($module, 'adminMenu'))
            //{
            $moduleInfo['admin_menu'] = $module->adminMenu();

//                $settins_count = Param::model()->count("module_id = '{$module_dir}'");
//                if ($settins_count)
//                {
//                    $module['admin_menu'][t('Параметры')] = Yii::app()->createUrl('/main/ParamAdmin/manage/',array('module_id' => $module_dir));
//                }

            if ($check_allowed_links)
            {
                foreach ($moduleInfo['admin_menu'] as $title => $url)
                {
                    if (!is_string($url))
                    {
                        continue;
                    }

                    $url = explode('/', trim($url, '/'));

                    if (count($url) < 3)
                    {
                        continue;
                    }

                    list($module_name, $controller, $action) = $url;

                    $auth_item = ucfirst($controller) . '_' . $action;

                    if (!RbacModule::isAllow($auth_item))
                    {
                        unset($moduleInfo['admin_menu'][$title]);
                    }
                }
            }
            //}

            $modules[$module_class] = $moduleInfo;
        }

        return $modules;
    }


    public function getModuleActions($module_class, $use_admin_prefix = false)
    {
        $actions = array();

        $controllers_dir = MODULES_PATH . lcfirst(str_replace('Module', '', $module_class)) . '/controllers/';
        if (!file_exists($controllers_dir))
        {
            return $actions;
        }

        $controllers = scandir($controllers_dir);
        foreach ($controllers as $controller)
        {
            if ($controller[0] == ".")
            {
                continue;
            }

            $class = str_replace('.php', '', $controller);
            if (!class_exists($class, false))
            {
                require_once $controllers_dir . $controller;
            }

            $reflection = new ReflectionClass($class);

            if (!in_array($reflection->getParentClass()->name, array('BaseController', 'AdminController')))
            {
                continue;
            }

            $actions[$class] = $class::actionsTitles();
        }

        return $actions;
    }


    public function getActionModule($action)
    {
        $controller_file = array_shift(explode("_", $action)) . "Controller.php";

        $modules_dirs = scandir(MODULES_PATH);
        foreach ($modules_dirs as $dir)
        {
            if ($dir[0] == ".")
            {
                continue;
            }

            $controllers = scandir(MODULES_PATH . "/" . $dir . "/controllers");

            if (in_array($controller_file, $controllers))
            {
                return ucfirst($dir) . "Module";
            }
        }
    }


    public static function getModuleName($id)
    {
        $module = Yii::app()->getModule($id);
        if ($module)
        {
            return $module->getName();
        }
    }


    public static function getModels($params = array())
    {
        $result = array();

        $modules_dirs = scandir(MODULES_PATH);
        foreach ($modules_dirs as $module_dir)
        {
            if ($module_dir[0] == '.')
            {
                continue;
            }

            $module_class = ucfirst($module_dir) . 'Module';

            if (array_key_exists('active', $params))
            {
                $active_attr = new ReflectionProperty($module_class, 'active');
                if ($active_attr->getValue() !== $params['active'])
                {
                    continue;
                }
            }

            $models_dir = MODULES_PATH . $module_dir . '/models';
            if (!file_exists($models_dir))
            {
                continue;
            }

            $models_files = scandir($models_dir);
            foreach ($models_files as $model_file)
            {
                if ($model_file[0] == '.')
                {
                    continue;
                }

                $model_class = str_replace('.php', null, $model_file);
                $class       = new ReflectionClass($model_class);
                if ($class->isSubclassOf('ActiveRecord'))
                {
                    $model = ActiveRecord::model($model_class);
                }
                else
                {
                    continue;
                }

                if (isset($params['meta_tags']))
                {
                    $behaviors = $model->behaviors();
                    $behaviors = ArrayHelper::extract($behaviors, 'class');

                    if (!in_array('application.components.activeRecordBehaviors.MetaTagBehavior', $behaviors))
                    {
                        continue;
                    }
                }

                $result[$model_class] = $model->name();
            }
        }

        return $result;
    }



    public static function getModulesClientMenu()
    {
        if (!self::$_modules_client_menu)
        {
            $modules_urls = array();

            $modules = self::getModulesData(true);

            foreach ($modules as $module)
            {
                if (method_exists($module['class'], 'clientMenu'))
                {
                    $client_menu = call_user_func(array($module['class'], 'clientMenu'));
                    if (is_array($client_menu))
                    {
                        $modules_urls = array_merge($modules_urls, $client_menu);
                    }
                }
            }

            self::$_modules_client_menu = array_flip($modules_urls);
        }

        return self::$_modules_client_menu;
    }


    public static function getModelModule($model_class)
    {
        $file = $model_class . '.php';

        foreach (glob(MODULES_PATH . '*') as $module_dir)
        {
            if (file_exists($module_dir . DS . 'models' . DS . $file))
            {
                return pathinfo($module_dir, PATHINFO_BASENAME);
            }
        }
    }


    public static function getModulesNames()
    {
        $names = array();
        foreach (Yii::app()->getModules() as $id => $config)
        {
            $names[$id] = Yii::app()->getModule($id)->name;
        }

        return $names;
    }
}


