<?php
 
class RuLatAlphaSpacesValidator extends CValidator
{
    const PATTERN_RULAT_ALPHA_SPACES = '/^[а-яa-z ]+$/ui';


    protected function validateAttribute($object, $attribute)
    {
        if (!empty($object->$attribute))
        {
            if (!preg_match(self::PATTERN_RULAT_ALPHA_SPACES, $object->$attribute))
            {
                $this->addError($object, $attribute, Yii::t('main', 'Только русский или латинский алфавит с учетом пробелов'));
            }
        }
    }
}
