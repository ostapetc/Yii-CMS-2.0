<?php
class YiiComponentPropertyIterator extends ArrayIterator
{
    public function __construct($object)
    {
        $attributes = $this->getObjectAttributes($object);
        $setters    = $this->getSettersAndGetters($object);
        $events     = $this->getEvents($object);
        $props      = array_keys(array_merge($attributes, $setters, $events));
        $props      = $this->filter($object, $props);
        $result     = array();
        foreach ($props as $prop)
        {
            $result[$prop] = $this->populateProperty($object, $prop);
        }

        parent::__construct($result);
    }

    public function filter($class, $props)
    {
        while($class = get_parent_class($class))
        {
            $parentProps = array_keys(DocBlockParser::parseClass($class)->properties);
            array_map(function($item) {
                return strtr($item, array('-write'=>'', '-read'=>''));
            }, $parentProps);
            $props = array_diff($props, $parentProps);
        }
        return $props;
    }

    public function getObjectAttributes($object)
    {
        if (method_exists($object, 'getAttributes'))
        {
            return $object->getAttributes();
        }
        return array();
    }

    public function getSettersAndGetters($object)
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
                $props = array_merge($props, $this->getSettersAndGetters($object->asa($id)));
            }
        }
        return $props;
    }


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


    public function isSettable($object, $prop)
    {
        $settable = property_exists($object, $prop);
        if (!$settable && method_exists($object, 'set' . $prop))
        {
            $m        = new ReflectionMethod($object, 'set' . $prop);
            $settable = $m->getNumberOfRequiredParameters() <= 1;
        }
        if (!$settable && strncasecmp($prop,'on',2) === 0 && method_exists($object, $prop))
        {
            $settable = true;
        }
        return $settable;
    }


    public function isGettable($object, $prop)
    {
        $gettable = property_exists($object, $prop);
        if (!$gettable && method_exists($object, 'get' . $prop))
        {
            $m        = new ReflectionMethod($object, 'get' . $prop);
            $gettable = $m->getNumberOfRequiredParameters() == 0;
        }
        if (!$gettable && strncasecmp($prop,'on',2) === 0 && method_exists($object, $prop))
        {
            $gettable = true;
        }
        return $gettable;
    }




    public function getTypeAndComment($object, $prop)
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
            $info['writeComment'] = $info['readComment']  = $parser->getShortDescription();
        }
        return $info;
    }


    public function populateProperty($object, $prop)
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
                $data = $this->populateProperty($object->asa($id), $prop);
                $res['settable'] = $res['settable'] || $data['settable'];
                $res['gettable'] = $res['gettable'] || $data['gettable'];
                $keys = array(
                    'writeType',
                    'readType',
                    'writeComment',
                    'readComment'
                );
                foreach ($keys as $key)
                {
                    $res [$key] =
                        $res[$key] ? $res[$key] :
                            $data[$key];
                }
            }
        }
        return $res;
    }

}