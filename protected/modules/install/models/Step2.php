<?php
/** 
 * 
 * !Attributes - атрибуты БД
 * @property        $admin_login
 * @property        $admin_pass
 * @property        $admin_pass_confirm
 * @property        $modules
 * @property        $save_site_actions
 * @property        $multilanguage_support
 * @property        $collect_routes_from_modules
 * @property        $themes_enabled
 * 
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property        $availableModules
 * @property        $mainConfigPatterns
 * @property        $configs
 * 
 */

class Step2 extends AbstractInstallModel {

    public $admin_login;
    public $admin_pass;
    public $admin_pass_confirm;

    public $modules;

    public $save_site_actions = true;
    public $multilanguage_support = true;
    public $collect_routes_from_modules = true;
    public $themes_enabled = false;

    public static function getAvailableModules()
    {
        foreach (Yii::app()->getModules() as $id => $config) {
            $res[$id] = $id;
        }
        return $res;
    }

    public function rules()
    {
        return array(
            array('admin_login', 'required'),
            array('admin_pass', 'required'),
            array(
                'admin_pass_confirm', 'compare',
                'compareAttribute'=> 'admin_pass'
            ),
            array('modules', 'safe')
        );
    }

    public function attributeLabels()
    {
        return array(
            'admin_login'                 => 'Логин администратора',
            'admin_pass'                  => 'Пароль администратора',
            'admin_pass_confirm'          => 'Пароль администратора, подтверждение',
            'modules'                     => 'Какие модули установить',

            'save_site_actions'           => 'Вести логирование доступа(access_log)',
            'multilanguage_support'       => 'Мультиязычный сайт',
            'collect_routes_from_modules' => 'Формировать роутинг из возвращаемых модулями данных (функция routes)',
            'themes_enabled'              => 'Будет ли сайт использовать несколько тем оформления'
        );
    }

    public function getMainConfigPatterns()
    {
        $modules = array();
        foreach (array_merge($this->modules, array('main', 'users', 'rbac')) as $module) {
            $modules[] = $module;
        }
        return array(
            'MODULES'                     => implode('", "', $modules),
            'SAVE_SITE_ACTIONS'           => $this->save_site_actions ? 'true' : 'false',
            'MULTILANGUAGE_SUPPORT'       => $this->multilanguage_support ? 'true' : 'false',
            'COLLECT_ROUTES_FROM_MODULES' => $this->collect_routes_from_modules ? 'true' : 'false',
            'THEMES_ENABLED'              => $this->themes_enabled ? 'true' : 'false',
        );
    }


    public function getConfigs()
    {
        return array(
            'main' => $this->getMainConfigPatterns()
        );
    }

}