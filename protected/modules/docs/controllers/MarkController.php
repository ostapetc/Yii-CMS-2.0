<?php
class MarkController extends CController
{
    public $layout = '/layouts/mark';

    public $meta_title;
    
    public static function actionsTitles()
    {

        return array(
            "index" => "Базовая документация",
            "module" => "Документация конкретного модуля",
        );
    }

    public function actionModule($module, $view)
    {
        $viewFile = Yii::app()->getModule($module)->getViewPath().'/docs/'.$view.'.php';
        $this->renderDocViewFile($viewFile);
    }

    public function actionIndex($view = 'index', $folder = '')
    {
        if ($folder)
        {
            $view = $folder.'/'.$view;
        }

        $viewFile = $this->getViewFile($view);
        $this->renderDocViewFile($viewFile);
    }

    public function getViewFile($view)
    {
        $viewFile = '';
        $data = explode('/', $view);
        $moduleId = array_shift($data);
        if (empty($data)) {
            $data[] = 'index';
        }
        $module = Yii::app()->getModule($moduleId);
        if ($module) {
            $viewFile = $module->getBasePath() . '/docs/' . implode('/', $data) . '.php';
        }
        if (!is_file($viewFile)) {
            $viewFile = parent::getViewFile($view);
        }
        return $viewFile;
    }

    public function renderDocViewFile($viewFile)
    {
        $md = new CMarkdown;
        $str = $this->renderFile($viewFile, array(), true);
        $str = $md->transform($str);

        $this->render('tmpl',array('content'=> $str));
    }
}