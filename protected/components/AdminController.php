<?php
 
abstract class AdminController extends BaseController
{
    public $layout='//layouts/admin/main';

    public $footer;

    public $crumbs = array();

    public $tabs;

    public function filters()
    {
        return CMap::mergeArray(parent::filters(),array(
            'postOnly + delete'
        ));
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

            foreach (scandir($dir) as $script)
            {
                if ($script[0] == '.')
                {
                    continue;
                }

                if ($dir_name == 'js')
                {
                    Yii::app()->clientScript->registerScriptFile($asset_dir . $script);
                }
                else if ($dir_name == 'css')
                {
                    Yii::app()->clientScript->registerCssFile($asset_dir . $script);
                }
            }
        }
    }


    public function beforeAction($action)
    {
        Yii::app()->bootstrap->init();

        if (Yii::app()->user->isGuest && ($action->id != 'login'))
        {
            $this->redirect(array('/admin/login'));
        }

        return parent::beforeAction($action);
    }
}
