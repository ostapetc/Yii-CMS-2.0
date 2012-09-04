<?php
class YiiComponentPropertyIterator extends ArrayIterator
{
    /**
     * Need for automatical align of strings
     *
     * @var int
     */
    protected $_maxLenOfType;

    /**
     * Need for automatical align of strings
     *
     * @var int
     */
    protected $_maxLenOfProperty;

    /**
     * Need for automatical align of strings
     *
     * @var int
     */
    protected $_maxLenOfTag;


    /**
     * @param CComponent $object
     * @param array      $propertyOptions
     */
    public function __construct(CComponent $object, $propertyOptions = array())
    {
        $attributes = $this->getObjectAttributes($object);
        $accessors  = $this->getAccessors($object);
        $events     = $this->getEvents($object);
        $props      = array_keys(array_merge($accessors, $attributes, $events));
        $props      = $this->filter($object, $props);
        $result     = array();

        foreach ($props as $prop)
        {
            $result[$prop] = $this->createPropertyInstance($object, $prop, $propertyOptions);
        }
        parent::__construct($result);
    }


    /**
     * Instanciate property by $propertyOptions
     *
     * @param $object
     * @param $prop
     * @param $propertyOptions
     *
     * @return mixed
     */
    protected function createPropertyInstance($object, $prop, $propertyOptions)
    {
        $property       = Yii::createComponent($propertyOptions);
        $property->name = $prop;
        $property->iterator = $this;
        $property->populate($object);
        $property->setOldValues(DocBlockParser::parseClass($object)->properties);
        return $property;
    }


    /**
     * Delete all properties that described in DocBlock of any parent class
     *
     * @param $class
     * @param $props
     *
     * @return array
     */
    public function filter($class, $props)
    {
        while ($class = get_parent_class($class))
        {
            $parentProps = array_keys(DocBlockParser::parseClass($class)->properties);
            array_map(function ($item)
            {
                return strtr($item, array(
                    '-write'=> '',
                    '-read' => ''
                ));
            }, $parentProps);
            $props = array_diff($props, $parentProps);
        }
        return $props;
    }


    /**
     * try to get attributes for object
     *
     * @param CComponent $object
     *
     * @return array
     */
    public function getObjectAttributes(CComponent $object)
    {
        if (method_exists($object, 'getAttributes'))
        {
            return $object->getAttributes();
        }
        return array();
    }


    /**
     * Get all accessors for object
     *
     * @param CComponent $object
     *
     * @return array
     */
    public function getAccessors(CComponent $object)
    {
        $props = array();
        foreach (get_class_methods($object) as $method)
        {
            if (strncasecmp($method, 'set', 3) === 0 || strncasecmp($method, 'get', 3) === 0)
            {
                $props[lcfirst(substr($method, 3))] = true;
            }
        }

        if (method_exists($object, 'behaviors'))
        {
            foreach ($object->behaviors() as $id => $data)
            {
                $props = array_merge($props, $this->getAccessors($object->asa($id)));
            }
        }
        return $props;
    }


    /**
     * Get all events for object
     *
     * @param CComponent $object
     *
     * @return array
     */
    public function getEvents(CComponent $object)
    {
        $events = array();
        foreach (get_class_methods($object) as $method)
        {
            if (strncasecmp($method, 'on', 2) === 0)
            {
                $events[$method] = true;
            }
        }
        return $events;
    }


    /**
     * Max of 'type' fields
     *
     * @return int
     */
    public function getMaxLenOfType()
    {
        if ($this->_maxLenOfType === null)
        {
            $clone = clone $this;
            $clone->rewind();
            $max = 0;
            foreach ($clone as $item)
            {
                $max = max($max, strlen($item->writeType), strlen($item->readType));
            }
            $this->_maxLenOfType = $max;
        }

        return $this->_maxLenOfType;
    }


    /**
     * Max of 'property' fields
     *
     * @return int
     */
    public function getMaxLenOfProperty()
    {
        if ($this->_maxLenOfProperty === null)
        {
            $clone = clone $this;
            $clone->rewind();
            $max = 0;
            foreach ($clone as $key => $item)
            {
                $max = max($max, strlen($key));
            }
            $this->_maxLenOfProperty = $max;
        }

        return $this->_maxLenOfProperty;
    }


    /**
     * Max of 'tag' fields
     *
     * @return int
     */
    public function getMaxLenOfTag()
    {
        if ($this->_maxLenOfTag === null)
        {
            $clone = clone $this;
            $clone->rewind();
            $max = 0;
            foreach ($clone as $item)
            {
                $tag = $item->getIsFullMode() ? ($item->gettable ? 'property-read' : 'property-write') : 'property';
                $max = max($max, strlen($tag));
            }
            $this->_maxLenOfTag = $max;
        }
        return $this->_maxLenOfTag;
    }

}