<?

class PhoneValidator extends CValidator
{
    const PATTERN = '/^\+[1-9]-[0-9]+-[0-9]{7}$/';


    protected function validateAttribute($object, $attribute)
    {
        if (!empty($object->$attribute))
        {
            if (!preg_match(self::PATTERN, $object->$attribute))
            {
                $this->addError($object, $attribute, Yii::t('main', 'Неверный формат! Пример: +7-903-5492969'));
            }
        }
    }
}
