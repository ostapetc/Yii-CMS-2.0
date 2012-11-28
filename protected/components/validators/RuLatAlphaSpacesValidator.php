<?
 
class RuLatAlphaSpacesValidator extends CValidator
{
    const PATTERN = '/^[а-яa-z ]+$/ui';


    protected function validateAttribute($object, $attribute)
    {
        if (!empty($object->$attribute))
        {
            if (!preg_match(self::PATTERN, $object->$attribute))
            {
                $this->addError($object, $attribute, 'Только русский или латинский алфавит с учетом пробелов');
            }
        }
    }
}
