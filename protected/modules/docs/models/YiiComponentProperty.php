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


    public $settable;
    public $gettable;
    public $readType;
    public $writeType;
    public $readComment;
    public $writeComment;


    public $oldWriteType;
    public $oldWriteComment;
    public $oldReadType;
    public $oldReadComment;


    public function __construct()
    {
    }


    public function __toString()
    {
        try
        {
            if ($this->getIsFullMode())
            {
                $docBlock = '';
                if ($this->settable)
                {
                    $docBlock .= $this->getLine('write');
                }
                if ($this->gettable)
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
            print_r($e->__toString());die;
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
            $fullAccess   = $this->settable && $this->gettable;
            $sameType     = $this->writeType == $this->readType;
            $sameDescribe = $this->writeComment == $this->readComment;
            return !$fullAccess || !$sameType || !$sameDescribe;
        }
    }


    protected function getLine($mode = null)
    {
        $tag        = $mode ? 'property-' . $mode : "property";
        $mode       = $mode ? $mode : 'read'; //read by default
        $commentKey = $mode . "Comment";
        $typeKey    = $mode . "Type";

        $comment = $this->$commentKey ? $this->$commentKey : $this->{'old' . ucfirst($mode) . 'Comment'};
        $type    = $this->$typeKey ? $this->$typeKey : $this->{'old' . ucfirst($mode) . 'Type'};

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


    public function merge($data)
    {
        foreach ($data as $key => $val)
        {
            if ($key == 'settable' || $key == 'gettable')
            {
                $this->$key = $this->$key || $val;
            }
            else
            {
                $this->$key = $this->$key ? $this->$key : $val;
            }
        }
    }


    public function populate(CComponent $object)
    {
        $this->settable = $this->settable || $this->isAccessor($object, 'set');
        $this->gettable = $this->gettable || $this->isAccessor($object, 'get');
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
            $this->oldReadType    = $properties[$this->name]['type'];
            $this->oldReadComment = $properties[$this->name]['comment'];
        }
        else
        {
            $key = $this->name . '-write';
            if (isset($properties[$key]))
            {
                $this->oldWriteType    = $properties[$key]['type'];
                $this->oldWriteComment = $properties[$key]['comment'];
            }
            $key = $this->name . '-read';
            if (isset($properties[$key]))
            {
                $this->oldReadType    = $properties[$key]['type'];
                $this->oldReadComment = $properties[$key]['comment'];
            }
        }
    }


    public function setTypeAndComment(CComponent $object)
    {
        if (property_exists($object, $this->name))
        {
            $data              = DocBlockParser::parseProperty($object, $this->name)->var;
            $this->readType    = $this->writeType = $data['type'];
            $this->readComment = $this->writeComment = $data['comment'];
        }
        if ($object->canSetProperty($this->name))
        {
            $data               = DocBlockParser::parseMethod($object, 'set' . $this->name)->params;
            $first              = array_shift($data); //get first param of setter
            $this->writeType    = $first['type'];
            $this->writeComment = $first['comment'];
        }
        if ($object->canGetProperty($this->name))
        {
            $data              = DocBlockParser::parseMethod($object, 'get' . $this->name)->return;
            $this->readType    = $data['type'];
            $this->readComment = $data['comment'];
        }
        if ($object->hasEvent($this->name))
        {
            $parser             = DocBlockParser::parseMethod($object, $this->name);
            $this->writeType    = $this->readType = "CList";
            $this->writeComment = $this->readComment = $parser->getShortDescription();
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
