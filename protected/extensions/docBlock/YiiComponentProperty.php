<?php
/**
 * Know all about CComponent, CModel, CActiveRecord and etc.
 */
class YiiComponentProperty extends DocBlockLine
{
    public $tag = 'property';

    public $toWrite;
    public $settable;
    public $gettable;

    public $readWriteDifferentiate = false;


    public function init()
    {
        if ($this->readWriteDifferentiate)
        {
            $this->toWrite           = new YiiComponentProperty;
            $this->toWrite->name     = $this->name;
            $this->toWrite->iterator = $this->iterator;
        }
    }


    public function getTagLen()
    {
        if ($this->getIsFullMode())
        {
            if ($this->settable && $this->gettable)
            {
                return strlen('property');
            }
            if ($this->settable)
            {
                return strlen('property-write');
            }
            if ($this->gettable)
            {
                return strlen('property-read');
            }
        }
        else
        {
            return strlen('property');
        }
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
                if ($this->settable)
                {
                    $this->toWrite->tag = 'property-write';
                    $docBlock .= $this->toWrite->getLine();
                }
                if ($this->gettable)
                {
                    $this->tag = 'property-read';
                    $docBlock .= $this->getLine();
                }
                return $docBlock;
            }
            else
            {
                $this->tag = 'property';
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
            $fullAccess   = $this->settable && $this->gettable;
            $sameType     = $this->toWrite->type == $this->type;
            $sameDescribe = $this->toWrite->comment == $this->comment;
            return !$fullAccess || !$sameType || !$sameDescribe;
        }
    }


    /**
     * Fill himself by $object properties
     *
     * @param $object
     */
    public function populate($object)
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


    /**
     * Check property on accessability(existing setter|getter|public property|event)
     *
     * @param CComponent $object
     * @param            $type set|get
     *
     * @return bool
     */
    public function isAccessor(CComponent $object, $type)
    {
        $accessor = property_exists($object, $this->name);
        if (!$accessor && $object->{'can' . ucfirst($type) . 'Property'}($this->name))
        {
            $m        = new ReflectionMethod($object, $type . $this->name);
            $accessor = $m->getNumberOfRequiredParameters() <= ($type == 'set' ? 1 : 0);
        }
        if (!$accessor)
        {
            $accessor = $object->hasEvent($this->name);
        }
        if (!$accessor && $object instanceof CActiveRecord)
        {
            $rels     = $object->relations();
            $accessor = isset($rels[$this->name]);
        }
        return $accessor;
    }


    /**
     * Parse existing comments for searching types or comments for property
     *
     * @param CComponent $object
     */
    public function setTypeAndComment(CComponent $object)
    {
        if (property_exists($object, $this->name))
        {
            $data                   = DocBlockParser::parseProperty($object, $this->name)->var;
            $this->toWrite->type    = $this->type = $data['type'];
            $this->toWrite->comment = $this->comment = $data['comment'];
        }
        if ($object->canSetProperty($this->name))
        {
            $data                   = DocBlockParser::parseMethod($object, 'set' . $this->name)->params;
            $first                  = array_shift($data); //get first param of setter
            $this->toWrite->type    = $first['type'];
            $this->toWrite->comment = $first['comment'];
        }
        if ($object->canGetProperty($this->name))
        {
            $data          = DocBlockParser::parseMethod($object, 'get' . $this->name)->return;
            $this->type    = $data['type'];
            $this->comment = $data['comment'];
        }
        if ($object->hasEvent($this->name))
        {
            $parser                 = DocBlockParser::parseMethod($object, $this->name);
            $this->toWrite->type    = $this->type = "CList";
            $this->toWrite->comment = $this->comment = $parser->getShortDescription();
        }
        if ($object instanceof CActiveRecord)
        {
            $rels = $object->relations();
            if (isset($rels[$this->name]))
            {
                list ($relType, $type) = $rels[$this->name];
                $returnArrayTypes = array(
                    CActiveRecord::HAS_MANY,
                    CActiveRecord::MANY_MANY
                );
                if (in_array($relType, $returnArrayTypes))
                {
                    $type = $type . '[]';
                }
                if ($relType == CActiveRecord::STAT)
                {
                    $type = 'int|null';
                }
                $this->toWrite->type = $this->type = $type;
            }
        }
    }


    public function setOldValues($properties)
    {
        if (isset($properties[$this->name]))
        {
            $this->oldType    = $properties[$this->name]['type'];
            $this->oldComment = $properties[$this->name]['comment'];
        }
        else
        {
            $key = $this->name . '-write';
            if (isset($properties[$key]))
            {
                $this->toWrite->oldType    = $properties[$key]['type'];
                $this->toWrite->oldComment = $properties[$key]['comment'];
            }
            $key = $this->name . '-read';
            if (isset($properties[$key]))
            {
                $this->oldType    = $properties[$key]['type'];
                $this->oldComment = $properties[$key]['comment'];
            }
        }
    }
}
