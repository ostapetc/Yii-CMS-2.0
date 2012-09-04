<?php
/**
 * Incapsulate property drawing logic
 */
abstract class DocBlockLine extends CComponent
{
    protected $tag;

    public $name;
    public $iterator;
    public $toUndercore = false;

    public $tagVerticalAlignment = true;
    public $typeVerticalAlignment = true;
    public $propertyVerticalAlignment = true;


    public $type;
    public $comment;


    public $oldType;
    public $oldComment;


    public function init()
    {

    }


    public function getTag()
    {
        return $this->tag;
    }

    public function setTag($val)
    {
        return $this->tag = $val;
    }



    /**
     * @return string combined doc string
     */
    public function __toString()
    {
        try
        {
            return $this->getLine();
        } catch (Exception $e)
        {
            Yii::app()->handleException($e);
        }
    }


    protected function getLine()
    {
        $tag     = $this->tag;
        $comment = $this->comment;
        $type    = $this->type;

        $property = $this->toUndercore ? $this->camelCaseToUnderscore($this->name) : $this->name;
        $this->align($tag, $type, $property);
        return "@$tag $type \$$property $comment\n";
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
            $property =
                $property . str_repeat(' ', $this->iterator->getMaxLenOfProperty() - strlen($property));
        }
    }


    public function setOldValues($properties)
    {
        if (isset($properties[$this->name]))
        {
            $this->oldType    = $properties[$this->name]['type'];
            $this->oldComment = $properties[$this->name]['comment'];
        }
    }


    /**
     * Fill himself by $object properties
     *
     * @param $object
     */
    abstract public function populate($object);


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
