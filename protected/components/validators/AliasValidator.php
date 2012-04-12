<?
 
class AliasValidator extends CValidator
{
    const PATTERN = '/^[A-Za-z_\-0-9]+$/ui';

    protected function validateAttribute($object, $attribute)
    {
        if (!empty($object->$attribute))
        {
            if (!preg_match(self::PATTERN, $object->$attribute))
            {
                $this->addError($object, $attribute, 'Для ввода используйте только латинские буквы, цифры и знаки: "-", "_". Использование пробела запрещено.');
            }
        }
    }
}
