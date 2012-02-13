<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artos
 * Date: 13.09.11
 * Time: 22:45
 * To change this template use File | Settings | File Templates.
 */

class ArrayHelper
{
    public static function extract($array_of_arrays, $key, $value = null)
    {
        $result = array();

        foreach ($array_of_arrays as $array)
        {
            if (is_object($array))
            {
                if ($value)
                {
                    if (isset($array->$key) && isset($array->$value))
                    {
                        $result[$array->$key] = $array->$value;
                    }
                }
                else
                {
                    if (isset($array->$key))
                    {
                        $result[] = $array->$key;
                    }
                }
            }
            elseif (is_array($array))
            {
                if ($value)
                {
                    if (array_key_exists($value, $array) && array_key_exists($key, $array))
                    {
                        $result[$array[$key]] = $array[$value];
                    }
                }
                else
                {
                    if (array_key_exists($key, $array))
                    {
                        $result[] = $array[$key];
                    }
                }
            }
        }

        return $result;
    }


    /**
     * аналог array_splice для ассоциативных массивов
     * можно задавать, как количество элементов для удаления, так и до какого ключа удалять(включительно)
     *
     * @static
     *
     * @param      $array
     * @param      $key    ключ
     * @param      $length количество элементво для удаления или ключ
     * @param bool $preserve_keys
     *
     * @return array
     */
    public static function slice_assoc($array, $key, $length, $preserve_keys = true)
    {
        $offset = array_search($key, array_keys($array));

        if (is_string($length))
        {
            $length = array_search($length, array_keys($array)) - $offset;
        }

        return array_slice($array, $offset, $length, $preserve_keys);
    }


    /**
     * @static
     *
     * @param Array $objects объекты или массивы
     * @param String $keyAttribute атрибут который будет выступать в роли ключа
     *
     * @return array
     */
    public static function markObjects($array, $keyAttribute)
    {
        return array_combine(ArrayHelper::extract($array, $keyAttribute), $array);
    }

}
