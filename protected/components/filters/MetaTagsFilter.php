<?
class MetaTagsFilter extends CFilter
{
    protected function preFilter($filterChain)
    {
        $controller = $filterChain->controller;
        if ($this instanceof AdminController)
        {
            return true;
        }

        if ($id = Yii::app()->request->getParam("id"))
        {
            $class = $controller->getModelClass();
            $controller->setMetaTags(CActiveRecord::model($class)->findByPk($id));
        }
        return true;
    }
}