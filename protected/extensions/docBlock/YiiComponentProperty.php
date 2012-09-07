<?php
/**
 * Know all about CComponent, CModel, CActiveRecord and etc.
 */
class YiiComponentProperty extends DocBlockLine  {

    public $readWriteDifferentiate = false; // not supported yet

    protected $_readType;
    protected $_writeType;
    protected $_readComment;
    protected $_writeComment;

    protected $_settable;
    protected $_gettable;

    protected $_oldWriteType;
    protected $_oldWriteComment;
    protected $_oldReadType;
    protected $_oldReadComment;

    public function afterPopulate()
    {
        $this->tag = 'property';
        $this->comment = $this->_readComment;
        $this->oldComment = $this->_oldReadComment;
        $this->type = $this->_readType;
        $this->oldType = $this->_oldReadType;
    }

    /**
     * @return string combined doc string
     */
    public function __toString()
    {
        try {
            if ($this->_settable || $this->_gettable) {
                return $this->getLine($this->tag, $this->type, "\$".$this->name, $this->comment);
            }
            return '';
        } catch (Exception $e) {
            Yii::app()->handleException($e);
        }
    }

    public function getNameLen()
    {
        return strlen("\$".$this->name);
    }

    /**
     * use or not
     *
     * @property-read/@property-write mode
     * @return bool
     */
    public function getIsFullMode()
    {
        if (!$this->readWriteDifferentiate) {
            return false;
        } else {
            $fullAccess = $this->_settable && $this->_gettable;
            $sameType = $this->_writeType == $this->_readType;
            $sameDescribe = $this->_writeComment == $this->_readComment;
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
        $this->_settable = $this->_settable || $this->isAccessor($object, 'set');
        $this->_gettable = $this->_gettable || $this->isAccessor($object, 'get');
        $this->setTypeAndComment($object);

        if (method_exists($object, 'behaviors')) {
            foreach ($object->behaviors() as $id => $data) {
                $this->populate($object->asa($id));
            }
        }
    }

    public function getTagLen()
    {
        return strlen('property');
//for full mode
        if ($this->getIsFullMode()) {
            if ($this->settable && $this->gettable) {
                return strlen('property');
            }
            if ($this->settable) {
                return strlen('property-write');
            }
            if ($this->gettable) {
                return strlen('property-read');
            }
        } else {
            return strlen('property');
        }
    }

    /**
     * Check property on accessability(existing setter|getter|public property|event)
     *
     * @param CComponent $object
     * @param            $type set|get
     * @return bool
     */
    public function isAccessor(CComponent $object, $type)
    {
        $accessor = property_exists($object, $this->name);
        if (!$accessor && $object->{'can' . ucfirst($type) . 'Property'}($this->name)) {
            $m = new ReflectionMethod($object, $type . $this->name);
            if ($m->getNumberOfRequiredParameters() <= ($type == 'set' ? 1 : 0)) {
                $accessor = true;
            } else {
                return false;
            }
        }
        if (!$accessor) {
            $accessor = $object->hasEvent($this->name);
        }
        if (!$accessor && $object instanceof CActiveRecord) {
            $rels = $object->relations();
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
        if (property_exists($object, $this->name)) {
            $data = DocBlockParser::parseProperty($object, $this->name)->var;
            $this->_readType = $this->_writeType = $data['type'];
            $this->_readComment = $this->_writeComment = $data['comment'];
        }
        if ($object->canSetProperty($this->name)) {
            $data = DocBlockParser::parseMethod($object, 'set' . $this->name)->params;
            $first = array_shift($data); //get first param of setter
            $this->_writeType = $first['type'];
            $this->_writeComment = $first['comment'];
        }
        if ($object->canGetProperty($this->name)) {
            $data = DocBlockParser::parseMethod($object, 'get' . $this->name)->return;
            $this->_readType = $data['type'];
            $this->_readComment = $data['comment'];
        }
        if ($object->hasEvent($this->name)) {
            $parser = DocBlockParser::parseMethod($object, $this->name);
            $this->_writeType = $this->_readType = "CList";
            $this->_writeComment = $this->_readComment = $parser->getShortDescription();
        }
        if ($object instanceof CActiveRecord) {
            $rels = $object->relations();
            if (isset($rels[$this->name])) {
                list ($relType, $type) = $rels[$this->name];
                $returnArrayTypes = array(
                    CActiveRecord::HAS_MANY,
                    CActiveRecord::MANY_MANY
                );
                if (in_array($relType, $returnArrayTypes)) {
                    $type = $type . '[]';
                }
                if ($relType == CActiveRecord::STAT) {
                    $type = 'int|null';
                }
                $this->_writeType = $this->_readType = $type;
            }
        }
    }


    public function setOldValues($properties)
    {
        if (isset($properties[$this->name])) {
            $this->_oldReadType = $properties[$this->name]['type'];
            $this->_oldReadComment = $properties[$this->name]['comment'];
        } else {
            $key = $this->name . '-write';
            if (isset($properties[$key])) {
                $this->_oldWriteType = $properties[$key]['type'];
                $this->_oldWriteComment = $properties[$key]['comment'];
            }
            $key = $this->name . '-read';
            if (isset($properties[$key])) {
                $this->_oldReadType = $properties[$key]['type'];
                $this->_oldReadComment = $properties[$key]['comment'];
            }
        }
    }
}
