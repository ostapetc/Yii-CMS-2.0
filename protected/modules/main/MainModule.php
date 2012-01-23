<?php

class MainModule extends WebModule
{
    public static $base_module = true;


    public static function description()
    {
        return 'Главный модуль';
    }


    public static function version()
    {
        return '1.0';
    }


    public static function name()
    {
        return 'Система';
    }


	public function init()
	{
		$this->setImport(array(
        	'main.models.*',
            'main.components.*',
		));
	}

	public static function adminMenu()
	{
        return array(
            'Мета-теги'         => '/main/MetaTagAdmin/manage',
            'Добавить мета-тег' => '/main/MetaTagAdmin/create',
			'Логирование'       => '/main/logAdmin/manage',
			'Действия сайта'    => '/main/SiteActionAdmin/manage',
			'Обратная связь'    => '/main/feedbackAdmin/manage',
			'Языки'             => '/main/LanguageAdmin/manage',
			'Добавить язык'     => '/main/LanguageAdmin/create',
            'Настройки'         => '/main/SettingAdmin/manage',
		);
	}


    public static function saveSiteAction()
    {
        $action = Yii::app()->controller->action;

        $action_titles = call_user_func(array(get_class(Yii::app()->controller), 'actionsTitles'));

        if (!isset($action_titles[ucfirst($action->id)]))
        {
            throw new CHttpException('Не найден заголовок для дейсвия ' . ucfirst($action->id));
        }

        $title = $action_titles[ucfirst($action->id)];

        $site_action = new SiteAction();
        $site_action->title      = $title;
        $site_action->module     = $action->controller->module->id;
        $site_action->controller = $action->controller->id;
        $site_action->action     = $action->id;

        if (!Yii::app()->user->isGuest)
        {
            $site_action->user_id = Yii::app()->user->id;
        }

        $site_action->save();
    }
}
