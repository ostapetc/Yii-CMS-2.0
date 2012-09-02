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
    protected $_maxLenOfParameter;


    public function __construct(CComponent $object)
    {
        $attributes = $this->getObjectAttributes($object);
        $accessors  = $this->getAccessors($object);
        $events     = $this->getEvents($object);
        $props      = array_keys(array_merge($accessors, $attributes, $events));
        $props      = $this->filter($object, $props);
        $result     = array();

        $parser = DocBlockParser::parseClass($object);
        foreach ($props as $prop)
        {
            $info = $this->populateProperty($object, $prop);
            if (!isset($parser->properties[$prop]))
            {
                $key                     = $prop . '-write';
                $info['oldWriteType']    = isset($parser->properties[$key]) ? $parser->properties[$key]['type'] : '';
                $info['oldWriteComment'] = isset($parser->properties[$key]) ? $parser->properties[$key]['comment'] : '';
                $key                     = $prop . '-read';
                $info['oldReadType']     = isset($parser->properties[$key]) ? $parser->properties[$key]['type'] : '';
                $info['oldReadComment']  = isset($parser->properties[$key]) ? $parser->properties[$key]['comment'] : '';
            }
            else
            {
                $info['oldType']    = $info['oldWriteType'] = $parser->properties[$prop]['type'];
                $info['oldComment'] = $info['oldWriteComment'] = $parser->properties[$prop]['comment'];
            }
            $result[$prop] = $info;
        }
        parent::__construct($result);
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
            $props       = array_diff($props, $parentProps);
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


    public function getObjectAttributes(CComponent $object)
    {
        if (method_exists($object, 'getAttributes'))
        {
            return $object->getAttributes();
        }
        return array();
    }


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


    public function isSettable(CComponent $object, $prop)
    {
        $settable = property_exists($object, $prop);
        if (!$settable && $object->canSetProperty($prop))
        {
            $m        = new ReflectionMethod($object, 'set' . $prop);
            $settable = $m->getNumberOfRequiredParameters() <= 1;
        }
        if (!$settable && strncasecmp($prop, 'on', 2) === 0 && method_exists($object, $prop))
        {
            $settable = true;
        }
        return $settable;
    }


    public function isGettable(CComponent $object, $prop)
    {
        $gettable = property_exists($object, $prop);
        if (!$gettable && $object->canGetProperty($prop))
        {
            $m        = new ReflectionMethod($object, 'get' . $prop);
            $gettable = $m->getNumberOfRequiredParameters() == 0;
        }
        if (!$gettable && strncasecmp($prop, 'on', 2) === 0 && method_exists($object, $prop))
        {
            $gettable = true;
        }
        return $gettable;
    }


    public function getTypeAndComment(CComponent $object, $prop)
    {
        $info = array(
            'readType'     => false,
            'writeType'    => false,
            'readComment'  => false,
            'writeComment' => false,
        );

        if (property_exists($object, $prop))
        {
            $data                = DocBlockParser::parseProperty($object, $prop)->var;
            $info['readType']    = $info['writeType'] = $data['type'];
            $info['readComment'] = $info['writeComment'] = $data['comment'];
        }
        if (method_exists($object, 'set' . $prop))
        {
            $data                 = DocBlockParser::parseMethod($object, 'set' . $prop)->params;
            $first                = array_shift($data); //get first param of setter
            $info['writeType']    = $first['type'];
            $info['writeComment'] = $first['comment'];
        }
        if (method_exists($object, 'get' . $prop))
        {
            $data                = DocBlockParser::parseMethod($object, 'get' . $prop)->return;
            $info['readType']    = $data['type'];
            $info['readComment'] = $data['comment'];
        }
        if (strncasecmp($prop, 'on', 2) === 0 && method_exists($object, $prop))
        {
            $parser               = DocBlockParser::parseMethod($object, $prop);
            $info['writeType']    = $info['readType'] = "CList";
            $info['writeComment'] = $info['readComment'] = $parser->getShortDescription();
        }

        return $info;
    }


    public function populateProperty(CComponent $object, $prop)
    {
        $res = array(
            'settable'      => $this->isSettable($object, $prop),
            'gettable'      => $this->isGettable($object, $prop),
        );
        $res = CMap::mergeArray($res, $this->getTypeAndComment($object, $prop));

        if (method_exists($object, 'behaviors'))
        {
            foreach ($object->behaviors() as $id => $data)
            {
                $data            = $this->populateProperty($object->asa($id), $prop);
                $res['settable'] = $res['settable'] || $data['settable'];
                $res['gettable'] = $res['gettable'] || $data['gettable'];
                $keys            = array(
                    'writeType',
                    'readType',
                    'writeComment',
                    'readComment'
                );
                foreach ($keys as $key)
                {
                    $res [$key] = $res[$key] ? $res[$key] : $data[$key];
                }
            }
        }
        return $res;
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
                $max = $max < strlen($item['writeType']) ? strlen($item['writeType']) : $max;
                $max = $max < strlen($item['readType']) ? strlen($item['readType']) : $max;
            }
            $max                 = $max < strlen($item['oldType']) ? strlen($item['oldType']) : $max;
            $this->_maxLenOfType = $max;
        }

        return $this->_maxLenOfType;
    }


    /**
     * Max of 'parameter' fields
     *
     * @return int
     */
    public function getMaxLenOfParameter()
    {
        if ($this->_maxLenOfParameter === null)
        {
            $clone = clone $this;
            $clone->rewind();
            $max = 0;
            foreach ($clone as $key => $item)
            {
                $max = $max < strlen($key) ? strlen($key) : $max;
            }
            $this->_maxLenOfParameter = $max;
        }

        return $this->_maxLenOfParameter;
    }
}