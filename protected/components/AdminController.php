<?php
 
abstract class AdminController extends BaseController
{
    public $layout='//layouts/admin';

    public $tabs;

    public function init()
    {
        parent::init();

        $admin_url = $this->url('/users/userAdmin/login');
        if (Yii::app()->user->isGuest && trim($_SERVER['REQUEST_URI'], '/') != trim($admin_url, '/'))
        {
            $this->redirect($admin_url);
        }

        $this->initTabs();
        //$this->initAssets();
    }


    private function initTabs()
    {
        $tabs = array();

        $actions_titles = call_user_func(array(get_class(Yii::app()->controller), 'actionsTitles'));
        foreach ($actions_titles as $action => $title)
        {
            if (in_array($action, array('Delete', 'Update', 'View')))
            {
                continue;
            }

            $tabs[$title] = $this->createUrl($action);
        }

        $this->tabs = $tabs;
    }


    private function initAssets()
    {
        $assets_dir = MODULES_PATH . Yii::app()->controller->module->id . '/assets/';
        if (!is_dir($assets_dir))
        {
            return;
        }

        $dir_names = array('css', 'js');
        foreach ($dir_names as $dir_name)
        {
            $dir = $assets_dir . $dir_name . '/';
            if (!is_dir($dir))
            {
                continue;
            }

            $asset_dir = Yii::app()->getAssetManager()->publish($dir) . '/';

            $scripts = scandir($dir);
            foreach ($scripts as $script)
            {
                if ($script[0] == '.')
                {
                    continue;
                }

                if ($dir_name == 'js')
                {
                    echo $asset_dir . $script . "<br>";
                    
                    Yii::app()->clientScript->registerScriptFile($asset_dir . $script);
                }
                else if ($dir_name == 'css')
                {
                    Yii::app()->clientScript->registerCssFile($asset_dir . $script);
                }
            }
        }
    }
}
