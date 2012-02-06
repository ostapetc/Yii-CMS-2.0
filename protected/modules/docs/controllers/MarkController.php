<?php
class MarkController extends CController
{
    public $layout = 'layouts/mark';

    public $meta_title;
    
    public static function actionsTitles()
    {

        return array(
            "Mark" => "Список новостей",
        );
    }

    public function actionIndex($view, $folder = '')
    {
        $md = new CMarkdown;
        if ($folder)
        {
            $view = $folder.'/'.$view;
        }

        $str = $this->renderPartial($view, array(), true);
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


}