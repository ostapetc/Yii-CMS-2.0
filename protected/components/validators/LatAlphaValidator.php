<?php
 
class LatAlphaValidator extends CValidator
{
    const PATTERN_LAT_ALPHA = '/^[A-Za-z]+$/ui';


    protected function validateAttribute($object, $attribute)
    {
        if (!empty($object->$attribute))
        {
            if (!preg_match(self::PATTERN_LAT_ALPHA, $object->$attribute))
            {
                $this->addError($object, $attribute, Yii::t('main', 'Только латинский алфавит'));
            }
        }
    }
}
