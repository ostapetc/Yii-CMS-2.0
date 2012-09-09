<?php
/**
 * @property $attributes
 * @property $events
 * @property $accessors
 * @property $relations
 * @property $scopes
 */
class YiiComponentPropertyIterator extends ArrayIterator
{
    protected $object;

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
    protected $_maxLenOfName;

    /**
     * Need for automatical align of strings
     *
     * @var int
     */
    protected $_maxLenOfTag;

    public $commentLanguage;
    public $commentCategory;
    public $addIllustrationCommetns = false;

    public $includeAttributes = true;
    public $includeEvents = true;
    public $includeAccessors = true;
    public $includeRelations = true;
    public $includeScopes = true;

    public $propertyOptions = array();
    public $methodOptions = array();


    /**
     * @param array      $initOptions
     * @param CComponent $object
     * @param array      $propertyOptions
     */
    public function __construct($initOptions)
    {
        foreach ($initOptions as $key => $val)
        {
            $this->$key = $val;
        }
        $props  = array_merge($this->attributes, $this->accessors, $this->events, $this->relations);
        $props  = $this->filterProperties($props);
        $result = array();
        foreach ($props as $prop)
        {
            if (is_object($prop))
            {
                $result[$prop->name] = $prop;
            }
            else
            {
                $result[$prop] = $this->createLineInstance($prop, $this->propertyOptions);
            }
        }

        $methods = array_merge($this->scopes);
        $methods = $this->filterMethods($methods);

        foreach ($methods as $prop)
        {
            if (is_object($prop))
            {
                $result[$prop->name] = $prop;
            }
            else
            {
                $result[$prop] = $this->createLineInstance($prop, $this->methodOptions);
            }
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
    protected function createLineInstance($prop, $lineOptions)
    {
        $property           = Yii::createComponent($lineOptions);
        $property->name     = $prop;
        $property->iterator = $this;
        $property->populate($this->object);
        $property->afterPopulate();
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
    public function filterProperties($props)
    {
        $class = get_class($this->object);
        while ($class = get_parent_class($class))
        {
            $parentProps = array_keys(DocBlockParser::parseClass($class)->properties);
            /*array_map(function ($item)
            {
                return strtr($item, array(
                    '-write'=> '',
                    '-read' => ''
                ));
            }, $parentProps);*/
            $props = array_diff($props, $parentProps);
        }
        return $props;
    }


    public function filterMethods($methods)
    {
        $class = get_class($this->object);
        while ($class = get_parent_class($class))
        {
            $parentMethods = array_keys(DocBlockParser::parseClass($class)->methods);
            $methods = array_diff($methods, $parentMethods);
        }
        return $methods;
    }


    /**
     * try to get attributes for object
     *
     * @return array
     */
    public function getAttributes($object)
    {
        $result = method_exists($object, 'getAttributes') ? array_keys($object->getAttributes()) : array();
        $this->addComment($result, 'Attributes');
        return $result;
    }


    /**
     * try to get scopes for AR
     *
     * @return array
     */
    public function getScopes($object)
    {
        $result = $object instanceof CActiveRecord ? array_keys($object->scopes()) : array();
        $this->addComment($result, 'Scopes');
        return $result;
    }


    /**
     * Get all accessors for object
     *
     * @return array
     */
    public function getAccessors($object)
    {
        $props = array();
        foreach (get_class_methods($object) as $method)
        {
            if (strncasecmp($method, 'set', 3) === 0 || strncasecmp($method, 'get', 3) === 0)
            {
                $props[] = lcfirst(substr($method, 3));
            }
        }

        if (method_exists($object, 'behaviors'))
        {
            foreach ($object->behaviors() as $id => $data)
            {
                if ($object->asa($id))
                {
                    Yii::log('If your components, implement "behaviors" method, than it must attach in constructor',
                        CLogger::LEVEL_WARNING, 'DocBlockCommand');
                    continue;
                }
                $props = array_merge($props, $this->getAccessors($object->asa($id)));
            }
        }
        $this->addComment($props, 'Accessors');
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
                $events[] = $method;
            }
        }
        $this->addComment($events, 'Events');
        return $events;
    }


    /**
     * Get all relations for AR
     *
     * @return array
     */
    public function getRelations($object)
    {
        $result = $object instanceof CActiveRecord ? array_keys($object->relations()) : array();
        $this->addComment($result, 'Relations');
        return $result;
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
                $max = max($max, strlen($item->type));
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
    public function getMaxLenOfName()
    {
        if ($this->_maxLenOfName === null)
        {
            $clone = clone $this;
            $clone->rewind();
            $max = 0;
            foreach ($clone as $item)
            {
                $max = max($max, $item->getNameLen());
            }
            $this->_maxLenOfName = $max;
        }

        return $this->_maxLenOfName;
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
                $max = max($max, $item->getTagLen());
            }
            $this->_maxLenOfTag = $max;
        }
        return $this->_maxLenOfTag;
    }


    public function addComment(&$array, $message)
    {
        if ($this->addIllustrationCommetns && $array)
        {
            $message = Yii::t($this->commentCategory, $message, null, 'docBlockMessage',
                $this->commentLanguage);
            array_unshift($array, new DocBlockComment($message));
        }
    }

}