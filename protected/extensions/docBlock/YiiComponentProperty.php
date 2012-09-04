<?php
/**
 * Know all about CComponent, CModel, CActiveRecord and etc.
 */
class YiiComponentProperty extends DocBlockProperty
{
    /**
     * Fill himself by $object properties
     *
     * @param $object
     */
    public function populate($object)
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
            $accessor = $object->hasRelated($this->name);
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
                $this->_writeType = $this->_readType = $type;
            }
        }
    }
}
