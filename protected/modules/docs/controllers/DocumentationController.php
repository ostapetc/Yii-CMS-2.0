<?php
class DocumentationController extends CController
{
    public $layout = '/layouts/mark';

    public $meta_title;

    public static function actionsTitles()
    {
        return array(
            "Index" => "Стартовая страница",
        );
    }

    public function actionIndex($alias = 'index', $folder = '')
    {
        $md = new CMarkdown;
        if ($folder)
        {
            $view = $folder.'/'.$alias;
        }
        else
        {
            $view = $alias;
        }
//        $content = Documentation::model()->findByAttributes(array('alias'=>$alias))->content;
        $content = $this->renderPartial($view, array(), true);
        $str = $md->transform($content);

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