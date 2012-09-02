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

    public $oldType;
    public $oldComment;

    public $oldWriteType;
    public $oldWriteComment;
    public $oldReadType;
    public $oldReadComment;


    protected function __construct()
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
            dump($e);
        }
    }


    /**
     * use or not
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
            if ($fullAccess && $sameType && $sameDescribe)
            {
                return false;
            }
            else
            {
                return true;
            }
        }
    }


    protected function getLine($mode = null)
    {
        $commentKey = $mode ? $mode . "Comment" : 'readComment';
        $typeKey    = $mode ? $mode . "Type" : 'readType';
        $tag        = $mode ? 'property-' . $mode : "property";

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
        return array(
            $tag,
            $type,
            $property
        );
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


    public static function getInstance(CComponent $object, $prop)
    {
        $property       = new static;
        $property->name = $prop;
        $property->populateProperty($object);

        if (method_exists($object, 'behaviors'))
        {
            foreach ($object->behaviors() as $id => $data)
            {
                $property->populateProperty($object->asa($id));
            }
        }
        return $property;
    }


    public function populateProperty(CComponent $object)
    {
        $this->settable = $this->isSettable($object);
        $this->gettable = $this->isGettable($object);
        $this->setTypeAndComment($object);

        if (method_exists($object, 'behaviors'))
        {
            foreach ($object->behaviors() as $id => $data)
            {
                $this->populateProperty($object->asa($id));
            }
        }
    }


    public function isSettable(CComponent $object)
    {
        $settable = property_exists($object, $this->name);
        if (!$settable && $object->canSetProperty($this->name))
        {
            $m        = new ReflectionMethod($object, 'set' . $this->name);
            $settable = $m->getNumberOfRequiredParameters() <= 1;
        }
        if (!$settable && strncasecmp($this->name, 'on', 2) === 0 && method_exists($object, $this->name))
        {
            $settable = true;
        }
        return $settable;
    }


    public function isGettable(CComponent $object)
    {
        $gettable = property_exists($object, $this->name);
        if (!$gettable && $object->canGetProperty($this->name))
        {
            $m        = new ReflectionMethod($object, 'get' . $this->name);
            $gettable = $m->getNumberOfRequiredParameters() == 0;
        }
        if (!$gettable && strncasecmp($this->name, 'on', 2) === 0 && method_exists($object, $this->name))
        {
            $gettable = true;
        }
        return $gettable;
    }


    public function setOldValues($properties)
    {
        if (!isset($properties[$this->name]))
        {
            $key                   = $this->name . '-write';
            $this->oldWriteType    = isset($properties[$key]) ? $properties[$key]['type'] : '';
            $this->oldWriteComment = isset($properties[$key]) ? $properties[$key]['comment'] : '';
            $key                   = $this->name . '-read';
            $this->oldReadType     = isset($properties[$key]) ? $properties[$key]['type'] : '';
            $this->oldReadComment  = isset($properties[$key]) ? $properties[$key]['comment'] : '';
        }
        else
        {
            $this->oldType    = $properties[$this->name]['type'];
            $this->oldComment = $properties[$this->name]['comment'];
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
        if (method_exists($object, 'set' . $this->name))
        {
            $data               = DocBlockParser::parseMethod($object, 'set' . $this->name)->params;
            $first              = array_shift($data); //get first param of setter
            $this->writeType    = $first['type'];
            $this->writeComment = $first['comment'];
        }
        if (method_exists($object, 'get' . $this->name))
        {
            $data              = DocBlockParser::parseMethod($object, 'get' . $this->name)->return;
            $this->readType    = $data['type'];
            $this->readComment = $data['comment'];
        }
        if (strncasecmp($this->name, 'on', 2) === 0 && method_exists($object, $this->name))
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
