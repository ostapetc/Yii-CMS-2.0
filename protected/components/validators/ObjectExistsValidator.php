<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artem.ostapetc
 * Date: 01.06.12
 * Time: 19:21
 * To change this template use File | Settings | File Templates.
 */
class ModelExistsValidator extends CValidator
{
    protected function validateAttribute($object, $attribute)
    {
        $model = ActiveRecord::model($object->model_id)->findByPk($object->object_id);
        if (!$model)
        {
            $this->addError($object, $attribute, "Объекта с моделью '{$object->model_id}' и ID '{$object->object_id}' не существует!");
        }
        else
        {
            if (property_exists($object, 'target_model'))
            {
                $object->target_model = $model;
            }
        }
    }
}
