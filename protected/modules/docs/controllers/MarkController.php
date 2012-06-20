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

    public function renderDocViewFile($viewFile)
    {
        $md = new CMarkdown;
        $str = $this->renderFile($viewFile, array(), true);
        $str = $md->transform($str);

        $this->render('tmpl',array('content'=>
            $this->compileDocSyntax($str)
        ));
    }

    protected function compileDocSyntax($str)
    {
        $str = preg_replace_callback("/\[#(\w+)\]/",array($this,'renderAnchor'),$str);
        return $str;
    }

    protected function renderAnchor($matches)
    {
        return "<span id='{$matches[1]}'></span>";
    }


    public function error()
    {

    }
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
    	    {
    	    	if(Yii::app()->request->isAjaxRequest)
    	    	{
    	    		echo $error['message'];
    	    	}
    	    	else
    	    	{
                    echo $error['message'];
//    	        	$this->render('error', $error);
    	        }
    	    }

    }
}