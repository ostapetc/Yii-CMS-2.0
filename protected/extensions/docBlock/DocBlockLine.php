<?php
/**
 * Incapsulate property drawing logic
 */
abstract class DocBlockLine extends CComponent
{

    public $name;
    public $iterator;
    public $toUnderscore = false;

    public $tagVerticalAlignment = true;
    public $typeVerticalAlignment = true;
    public $propertyVerticalAlignment = true;

    public $tag;

    public $type;
    public $comment;

    public $oldType;
    public $oldComment;


    /**
     * Get _property or him _oldProperty variant
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->{'_' . $name} ? $this->{'_' . $name} : $this->{'_old' . ucfirst($name)};
    }


    protected function getLine($tag, $type, $property, $comment)
    {
        $property = $this->toUnderscore ? $this->camelCaseToUnderscore($property) : $property;
        $this->align($tag, $type, $property);

        return "@$tag $type $property $comment\n";
    }


    public function align(&$tag, &$type, &$property)
    {
        if ($this->tagVerticalAlignment)
        {
            $tag = $tag . str_repeat(' ', $this->iterator->getMaxLenOfTag() - strlen($tag));
        }
        if ($this->typeVerticalAlignment)
        {
            $type = $type . str_repeat(' ', $this->iterator->getMaxLenOfType() - strlen($type));
        }
        if ($this->propertyVerticalAlignment)
        {
            $property = $property . str_repeat(' ', $this->iterator->getMaxLenOfName() - strlen($property));
        }
    }


    /**
     * Fill himself by $object properties
     *
     * @param $object
     */
    abstract public function populate($object);


    abstract public function afterPopulate();


    abstract public function getTagLen();


    abstract public function getNameLen();


    abstract public function getTypeLen();

    abstract public function setOldValues($object);

    public function _setOldValues($properties)
    {
        if (isset($properties[$this->name]))
        {
            $this->oldType    = $properties[$this->name]['type'];
            $this->oldComment = $properties[$this->name]['comment'];
        }
    }


    /**
     * Proxy method for external component
     *
     * @param string $str
     *
     * @return string
     */
    protected function camelCaseToUnderscore($str)
    {
        return Yii::app()->text->camelCaseToUnderscore($str);
    }
}
