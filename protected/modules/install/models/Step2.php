<?php
class Step2 extends FormModel
{

    public $admin_login;
    public $admin_pass;
    public $admin_pass_confirm;

    public $modules;

    public $save_site_actions = true;
    public $multilanguage_support = true;
    public $collect_routes_from_modules = true;
    public $themes_enabled = false;

    public static $available_modules
        = array(
            'content'     => 'content',
            'codegen'    => 'condegen',
            'fileManager' => 'fileManager',
            'mailer'      => 'mailer',
        );

    public function rules()
    {
        return array(
            array('admin_login', 'required'),
            array('admin_pass', 'required'),
            array('admin_pass_confirm', 'compare',
                  'compareAttribute'=> 'admin_pass'),
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
        foreach (array_merge($this->modules, array('main', 'users', 'rbac')) as $module)
        {
            $module[] = "'".$module."'";
        }
        return array(
            '%MODULES%'                     => implode(', ',$modules),
            '%SAVE_SITE_ACTIONS%'           => $this->save_site_actions ? 'true' : 'false',
            '%MULTILANGUAGE_SUPPORT%'       => $this->multilanguage_support ? 'true' : 'false',
            '%COLLECT_ROUTES_FROM_MODULES%' => $this->collect_routes_from_modules ? 'true' : 'false',
            '%THEMES_ENABLED%'              => $this->themes_enabled ? 'true' : 'false',
        );
    }

}