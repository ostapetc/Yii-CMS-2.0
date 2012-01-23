<?php

if (!function_exists('get_called_class'))
{
    function get_called_class()
    {
        $matches = array();
        $bt      = debug_backtrace();
        $l       = 0;
        do
        {
            $l++;
            if (isset($bt[$l]['class']) AND !empty($bt[$l]['class']))
            {
                return $bt[$l]['class'];
            }
            $lines      = file($bt[$l]['file']);
            $callerLine = $lines[$bt[$l]['line'] - 1];
            preg_match('/([a-zA-Z0-9\_]+)::' . $bt[$l]['function'] . '/', $callerLine, $matches);
            if (!isset($matches[1]))
            {
                $matches[1] = NULL;
            } //for notices
            if ($matches[1] == 'self')
            {
                $line = $bt[$l]['line'] - 1;
                while ($line > 0 && strpos($lines[$line], 'class') === false)
                {
                    $line--;
                }
                preg_match('/class[\s]+(.+?)[\s]+/si', $lines[$line], $matches);
            }
        } while ($matches[1] == 'parent' && $matches[1]);
        return $matches[1];
    }
}

if (function_exists('lcfirst') === false)
{
    function lcfirst($str)
    {
        $str[0] = strtolower($str[0]);
        return $str;
    }

}

if (!function_exists('array_replace'))
{
    function array_replace()
    {
        $array = array();
        $n     = func_num_args();
        while ($n-- > 0)
        {
            $array += func_get_arg($n);
        }
        return $array;
    }
}
