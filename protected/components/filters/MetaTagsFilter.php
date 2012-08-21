<?
class MetaTagsFilter extends CFilter
{
    public $findAttribute = 'id';
    public $getParam = 'id';

    protected function preFilter($filterChain)
    {
        $controller = $filterChain->controller;
        if ($this instanceof AdminController)
        {
            return true;
        }

        if ($val = Yii::app()->request->getParam($this->getParam))
        {
            $class = $controller->getModelClass();
            $model = CActiveRecord::model($class)->findByAttributes(array($this->findAttribute => $val));
            if ($model)
            {
                $controller->setMetaTags($model);
            }
        }
        return true;
    }
}