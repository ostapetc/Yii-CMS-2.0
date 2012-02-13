<?php
 
class AliasValidator extends CValidator
{
    const PATTERN_LAT_ALPHA = '/^[A-Za-z_\-0-9]+$/ui';

    protected function validateAttribute($object, $attribute)
    {
        if (!empty($object->$attribute))
        {
            if (!preg_match(self::PATTERN_LAT_ALPHA, $object->$attribute))
            {
                $this->addError($object, $attribute, Yii::t('main', 'Для ввода используйте только латинские буквы, цифры и знаки: "-", "_". Использование пробела запрещено.'));
            }
        }
    }
}
