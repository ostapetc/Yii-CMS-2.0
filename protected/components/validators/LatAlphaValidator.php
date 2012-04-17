<?
 
class LatAlphaValidator extends CValidator
{
    const PATTERN = '/^[A-Za-z]+$/ui';


    protected function validateAttribute($object, $attribute)
    {
        if (!empty($object->$attribute))
        {
            if (!preg_match(self::PATTERN, $object->$attribute))
            {
                $this->addError($object, $attribute, 'Только латинский алфавит');
            }
        }
    }
}
