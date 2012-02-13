<?php

class StringHelper
{
    public static function underscoreToCamelcase($string)
    {
        $result = '';

        $string = explode('_', $string);
        foreach ($string as $i => $sub_string)
        {
            if ($i != 0)
            {
                $sub_string = ucfirst($sub_string);
            }

            $result.= $sub_string;
        }

        return $result;
    }


    public static function camelCaseToUnderscore($string)
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $string));
    }
}

