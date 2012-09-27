<?php
class ApiCriteria extends CComponent
{
    public $select = null;
    public $limit  = 1;
    public $offset = 0;
    public $order  = null;
    public $pk     = null;

    /**
     * Constructor.
     * @param array $data criteria initial property values (indexed by property name)
     */
    public function __construct($data=array())
    {
        foreach($data as $name=>$value)
            $this->$name=$value;
    }

    public function mergeWith($props)
    {
        if (is_object($props))
        {
            $props = $props->toArray();
        }
        foreach ($props as $key => $val)
        {
            if ($val === null)
            {
                continue;
            }
            if (is_array($val))
            {
                $this->$key = CMap::mergeArray($this->$key, $val);
            }
            else
            {
                $this->$key = $val;
            }
        }
    }

    public function toArray()
    {
        $ref = new ReflectionObject($this);
        $public = $ref->getProperties(ReflectionProperty::IS_PUBLIC);
        $static = $ref->getProperties(ReflectionProperty::IS_STATIC);
        $res = array();
        foreach (array_diff($public, $static) as $prop)
        {
            $res[$prop->name] = $this->{$prop->name};
        }
        return $res;
    }

    public function toCacheKey()
    {
        $uniq_str = implode('_', $this->toArray());
        return get_class($this) . '_' . md5($uniq_str);
    }
}
