<?php

function p($data)
{
    echo '<pre>';
    CVarDumper::dump($data, 1000, false);
    echo '</pre>';
}


function v($data)
{
    echo "<pre>".var_dump($data)."</pre>";
}


if (function_exists('get_called_class') === false)
{
    function get_called_class()
    {
        $bt    = debug_backtrace();
        $lines = file($bt[1]['file']);
        preg_match('/([a-zA-Z0-9\_]+)::'.$bt[1]['function'].'/', $lines[$bt[1]['line'] - 1], $matches);
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


function t($message)
{
    $modules_classes = array_keys(AppManager::getModulesData(true));

    $modules_classes[] = 'MainModule';
    $modules_classes[] = get_class(Yii::app()->controller->module);

    krsort($modules_classes);

    $modules_classes = array_unique($modules_classes);

    foreach ($modules_classes as $module_class)
    {
        $translated_message = Yii::t($module_class . '.main', $message);
        if ($translated_message != $message)
        {
            return $translated_message;
        }
    }

    return $message;
}