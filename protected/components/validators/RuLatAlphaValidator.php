<?php

class RuLatAlphaValidator extends CValidator
{
    const PATTERN_RULAT_ALPHA = '/^[а-яa-z]+$/ui';


    protected function validateAttribute($object, $attribute)
    {
        if (!empty($object->$attribute))
        {
            if (!preg_match(self::PATTERN_RULAT_ALPHA, $object->$attribute))
            {
                $this->addError($object, $attribute, Yii::t('main', 'Только русский или латинский алфавит'));
            }
        }
    }
}
