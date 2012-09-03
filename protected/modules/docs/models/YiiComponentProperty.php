<?php
class YiiComponentProperty extends CComponent
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


    public function __get($name)
    {
        return $this->{'_' . $name} ? $this->{'_' . $name} : $this->{'_old' . ucfirst($name)};
    }


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
        }
        catch (Exception $e)
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


    public function populate(CComponent $object)
    {
        $this->_settable = $this->_settable || $this->isAccessor($object, 'set');
        $this->_gettable = $this->_gettable || $this->isAccessor($object, 'get');
        $this->setTypeAndComment($object);

        if (method_exists($object, 'behaviors'))
        {
            foreach ($object->behaviors() as $id => $data)
            {
                $this->populate($object->asa($id));
            }
        }
    }


    public function isAccessor(CComponent $object, $type)
    {
        $accessor = property_exists($object, $this->name);
        if (!$accessor && $object->{'can' . ucfirst($type) . 'Property'}($this->name))
        {
            $m        = new ReflectionMethod($object, $type . $this->name);
            $accessor = $m->getNumberOfRequiredParameters() <= ($type == 'set' ? 1 : 0);
        }
        if (!$accessor && $object->hasEvent($this->name))
        {
            $accessor = true;
        }
        return $accessor;
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


    public function setTypeAndComment(CComponent $object)
    {
        if (property_exists($object, $this->name))
        {
            $data               = DocBlockParser::parseProperty($object, $this->name)->var;
            $this->_readType    = $this->_writeType = $data['type'];
            $this->_readComment = $this->_writeComment = $data['comment'];
        }
        if ($object->canSetProperty($this->name))
        {
            $data                = DocBlockParser::parseMethod($object, 'set' . $this->name)->params;
            $first               = array_shift($data); //get first param of setter
            $this->_writeType    = $first['type'];
            $this->_writeComment = $first['comment'];
        }
        if ($object->canGetProperty($this->name))
        {
            $data               = DocBlockParser::parseMethod($object, 'get' . $this->name)->return;
            $this->_readType    = $data['type'];
            $this->_readComment = $data['comment'];
        }
        if ($object->hasEvent($this->name))
        {
            $parser              = DocBlockParser::parseMethod($object, $this->name);
            $this->_writeType    = $this->_readType = "CList";
            $this->_writeComment = $this->_readComment = $parser->getShortDescription();
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
