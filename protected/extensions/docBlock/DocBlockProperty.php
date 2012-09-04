<?php
/**
 * Incapsulate property drawing logic
 */
abstract class DocBlockProperty extends CComponent
{
    public $name;
    public $iterator;
    public $toUndercore = false;
    public $readWriteDifferentiate = false;

    public $tagVerticalAlignment = true;
    public $typeVerticalAlignment = true;
    public $propertyVerticalAlignment = true;


    protected $_settable;
    protected $_gettable;
    protected $_readType;
    protected $_writeType;
    protected $_readComment;
    protected $_writeComment;


    protected $_oldWriteType;
    protected $_oldWriteComment;
    protected $_oldReadType;
    protected $_oldReadComment;


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


    /**
     * @return string combined doc string
     */
    public function __toString()
    {
        try
        {
            if ($this->getIsFullMode())
            {
                $docBlock = '';
                if ($this->_settable)
                {
                    $docBlock .= $this->getLine('write');
                }
                if ($this->_gettable)
                {
                    $docBlock .= $this->getLine('read');
                }
                return $docBlock;
            }
            else
            {
                return $this->getLine();
            }
        } catch (Exception $e)
        {
            Yii::app()->handleException($e);
        }
    }


    /**
     * use or not
     *
     * @property-read/@property-write mode
     *
     * @return bool
     */
    public function getIsFullMode()
    {
        if (!$this->readWriteDifferentiate)
        {
            return false;
        }
        else
        {
            $fullAccess   = $this->_settable && $this->_gettable;
            $sameType     = $this->_writeType == $this->_readType;
            $sameDescribe = $this->_writeComment == $this->_readComment;
            return !$fullAccess || !$sameType || !$sameDescribe;
        }
    }


    protected function getLine($mode = null)
    {
        $tag        = $mode ? 'property-' . $mode : "property";
        $mode       = $mode ? $mode : 'read'; //read by default
        $commentKey = $mode . "Comment";
        $typeKey    = $mode . "Type";

        $comment = $this->$commentKey;
        $type    = $this->$typeKey;

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
            $this->_oldReadType    = $properties[$this->name]['type'];
            $this->_oldReadComment = $properties[$this->name]['comment'];
        }
        else
        {
            $key = $this->name . '-write';
            if (isset($properties[$key]))
            {
                $this->_oldWriteType    = $properties[$key]['type'];
                $this->_oldWriteComment = $properties[$key]['comment'];
            }
            $key = $this->name . '-read';
            if (isset($properties[$key]))
            {
                $this->_oldReadType    = $properties[$key]['type'];
                $this->_oldReadComment = $properties[$key]['comment'];
            }
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
