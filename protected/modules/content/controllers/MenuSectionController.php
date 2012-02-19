<?php

class MenuSectionController extends BaseController
{
    public static function actionsTitles()
    {
        return array(
            "View"   => "Просмотр страницы",
        );
    }


    public function actionView($id)
    {
        $model = $this->loadModel($id, array('visible'));
        $model->checkAccess();
        $children = array();
        foreach ($model->children()->findAll() as $child)
        {
            if ($child->checkAccess())
            {
                $children[] = $child;
            }
        }

        $this->render("view", array(
            "children"    => $children,
            "section"    => $model
        ));
    }
}
