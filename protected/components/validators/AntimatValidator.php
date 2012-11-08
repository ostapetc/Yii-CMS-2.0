<?
 
class AntimatValidator extends CValidator
{
    protected function validateAttribute($object, $attribute)
    {
        if (Yii::app()->text->antimat($object->$attribute))
        {
            $this->addError($object, $attribute, 'Текст не прошел антимат проверку.');
        }
    }
}
