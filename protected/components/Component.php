<?php

/**
 * Created by JetBrains PhpStorm.
 * User: os
 * Date: 07.10.12
 * Time: 23:58
 * To change this template use File | Settings | File Templates.
 */

class Component extends CComponent
{
    public function __get($name)
    {
        try
        {
            return parent::__get($name);
        }
        catch (CException $e)
        {
            $method_name = Yii::app()->text->underscoreToCamelcase($name);
            $method_name = 'get' . ucfirst($method_name);

            if (method_exists($this, $method_name))
            {
                return $this->$method_name();
            }
            else
            {
                throw new CException($e->getMessage());
            }
        }
    }


    public function __set($name, $val)
    {
        try
        {
            return parent::__set($name, $val);
        }
        catch (CException $e)
        {
            $method_name = Yii::app()->text->underscoreToCamelcase($name);
            $method_name = 'set' . ucfirst($method_name);

            if (method_exists($this, $method_name))
            {
                return $this->$method_name($val);
            }
            else
            {
                throw new CException($e->getMessage());
            }
        }
    }
}
