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

            $meta_tag = MetaTag::model()->findByAttributes(array(
                'model_id'  => $class,
                'object_id' => $id
            ));

            if ($meta_tag)
            {
                $controller->meta_title       = $meta_tag->title;
                $controller->meta_keywords    = $meta_tag->keywords;
                $controller->meta_description = $meta_tag->description;
            }
        }
        return true;
    }
}