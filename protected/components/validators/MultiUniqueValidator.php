<?php
/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 16.06.12
 * Time: 21:04
 * To change this template use File | Settings | File Templates.
 */
class MultiUniqueValidator extends CValidator
{
    public $unique_attributes;


    public function validateAttribute($object, $attribute)
    {
        if (!is_array($this->unique_attributes))
        {
            throw new CException(t('параметр unique_attributes толжен быть массивом'));
        }

        foreach ($this->unique_attributes as $i => $unique_attribute)
        {
            unset($this->unique_attributes[$i]);
            $this->unique_attributes[$unique_attribute] = $object->$unique_attribute;
        }

        $model = $object->findByAttributes($this->unique_attributes);
        if ($model && ($model->id != $object->id))
        {
            $this->addError($object, $attribute, t('не уникально по полям ') . implode(', ', array_keys($this->unique_attributes)));
        }
    }
}
