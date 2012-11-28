<?
 
class CityValidator extends CValidator
{
    protected function validateAttribute($object, $attribute)
    {
    	$name = trim($object->$attribute);

    	if (!empty($name))
    	{
    		if (!is_numeric($name))
    		{
		    	$city = City::model()->findByAttributes(array('name' => $name));
		    	if ($city)
		    	{
		    		$object->$attribute = $city->id;
		    	}
		    	else
		    	{
		    		$this->addError($object, $attribute, 'Город не найден');
		    	}
    		}
    	}
    	else
    	{
    		$object->$attribute = null;
    	}
    }
}
