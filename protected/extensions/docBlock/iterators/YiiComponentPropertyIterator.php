<?php
/**
 * @property $attributes
 * @property $events
 * @property $accessors
 * @property $relations
 * @property $scopes
 * @property-read array  $methods
 */
class YiiComponentPropertyIterator extends ArrayIterator
{
    public  $object;

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

    public $generatePropertiesFor;
    public $generateMethodsFor;

    public $propertyOptions = array();
    public $methodOptions = array();


    /**
     * @param array      $initOptions
     * @param CComponent $object
     */
    public function __construct($initOptions)
    {
        foreach ($initOptions as $key => $val)
        {
            $this->$key = $val;
        }
        $props = array();
        foreach ($this->generatePropertiesFor as $item)
        {
            $props = array_merge($props, $this->$item);
        }

        foreach ($this->generateMethodsFor as $item)
        {
            $props = array_merge($props, $this->$item);
        }

        parent::__construct($props);
    }


    public function __get($name)
    {
        $props = $this->{'get' . ucfirst($name)}($this->object);

        //filter it
        $class = get_class($this->object);
        while ($class = get_parent_class($class))
        {
            $parser = DocBlockParser::parseClass($class);
            if (in_array($name, $this->generatePropertiesFor))
            {
                $parentProps = array_keys($parser->properties);
            }
            elseif (in_array($name, $this->generateMethodsFor))
            {
                $parentProps = array_keys($parser->methods);
            }
            else
            {
                throw new CException("Allowed types values is 'attributes', 'events', 'accessors', 'relations', 'scopes'");
            }
            /*array_map(function ($item)
           {
               return strtr($item, array(
                   '-write'=> '',
                   '-read' => ''
               ));
           }, $parentProps);*/
            $props = array_diff($props, $parentProps);
        }

        //instant it
        if (in_array($name, $this->generatePropertiesFor))
        {
            $result = $this->instantAll($props, $this->propertyOptions);
        }
        elseif (in_array($name, $this->generateMethodsFor))
        {
            $result = $this->instantAll($props, $this->methodOptions);
        }

        $filteredResult = array();
        foreach($result as $key => $val)
        {
            if ($val->canDraw())
            {
                $filteredResult[$key] = $val;
            }
        }

        //add comment if need
        $this->addComment($filteredResult, $name);
        return $filteredResult;
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


    public function instantAll($props, $optioins)
    {
        $result = array();
        foreach ($props as $prop)
        {
            $result[$prop] = $this->createLineInstance($prop, $optioins);
        }
        return $result;
    }


    /**
     * try to get attributes for object
     *
     * @return array
     */
    public function getAttributes($object)
    {
        return method_exists($object, 'getAttributes') ? array_keys($object->getAttributes()) : array();
    }


    /**
     * try to get scopes for AR
     *
     * @return array
     */
    public function getScopes($object)
    {
        return $object instanceof CActiveRecord ? array_keys($object->scopes()) : array();
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
        return $events;
    }


    /**
     * Get all relations for AR
     *
     * @return array
     */
    public function getRelations($object)
    {
        return $object instanceof CActiveRecord ? array_keys($object->relations()) : array();
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
            for ($max = 0, $it = clone $this, $it->rewind(); $it->valid(); $it->next())
            {
                $max = max($max, strlen($it->current()->type));
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
            for ($max = 0, $it = clone $this, $it->rewind(); $it->valid(); $it->next())
            {
                $max = max($max, $it->current()->getNameLen());
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
            for ($max = 0, $it = clone $this, $it->rewind(); $it->valid(); $it->next())
            {
                $max = max($max, $it->current()->getTagLen());
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