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

    public $includeAttributes = true;
    public $includeEvents = true;
    public $includeAccessors = true;
    public $includeRelations = true;


    /**
     * @param array      $initOptions
     * @param CComponent $object
     * @param array      $propertyOptions
     */
    public function __construct($initOptions, CComponent $object, $propertyOptions = array())
    {
        foreach ($initOptions as $key => $val)
        {
            $this->$key = $val;
        }
        $this->object = $object;
        $props        = array_merge($this->attributes, $this->accessors, $this->events, $this->relations);
        $props        = $this->filter(array_keys($props));
        $result       = array();
        foreach ($props as $prop)
        {
            $result[$prop] = $this->createPropertyInstance($prop, $propertyOptions);
        }
        parent::__construct($result);
    }


    public function __get($name)
    {
        return $this->{'include' . ucfirst($name)} ? $this->{'get' . ucfirst($name)}($this->object) : array();
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
    protected function createPropertyInstance($prop, $propertyOptions)
    {
        $property           = Yii::createComponent($propertyOptions);
        $property->name     = $prop;
        $property->iterator = $this;
        $property->populate($this->object);
        $property->setOldValues(DocBlockParser::parseClass($this->object)->properties);
        return $property;
    }


    /**
     * Delete all properties that described in DocBlock of any parent class
     *
     * @param $props
     *
     * @return array
     */
    public function filter($props)
    {
        $class = get_class($this->object);
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
     * @return array
     */
    public function getAttributes($object)
    {
        return method_exists($object, 'getAttributes') ? $object->getAttributes() : array();
    }


    /**
     * Get all accessors for object
     *
     * @return array
     */
    public function getAccessors($object)
    {
        $props = array();
        foreach (get_class_methods($this->object) as $method)
        {
            if (strncasecmp($method, 'set', 3) === 0 || strncasecmp($method, 'get', 3) === 0)
            {
                $props[lcfirst(substr($method, 3))] = true;
            }
        }

        if (method_exists($object, 'behaviors'))
        {
            foreach ($this->object->behaviors() as $id => $data)
            {

                $props = array_merge($props, $this->getAccessors($this->object->asa($id)));
            }
        }
        return $props;
    }


    /**
     * Get all events for object
     *
     * @return array
     */
    public function getEvents($object)
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
     * Get all relations for AR
     *
     * @return array
     */
    public function getRelations($object)
    {
        return $object instanceof CActiveRecord ? $object->relations() : array();
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