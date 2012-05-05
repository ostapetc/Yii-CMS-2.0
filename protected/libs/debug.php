<?php
/**
 * Debug функция, использемая только для отладки
 *
 * @param $var
 * @param int $skipCount
 * @param int $depth
 */
function dump($var, $skipCount = 0, $depth = 2)
{
    static $startSkipCount = 0;
    static $localSkipCount = 0;

    if ($startSkipCount == 0) {
        $startSkipCount = $localSkipCount = $skipCount;
    }
    else
    {
        $localSkipCount--;
    }

    if ($localSkipCount == 0)
    {
        $startSkipCount = 0;

        echo '<pre>';
        CVarDumper::dump($var, $depth, true);
        echo '</pre>';

        exit();
    }
}

/**
 * Выводит текст и завершает приложение (применяется в ajax-действиях)
 *
 * @param string|array $text текст|массив для вывода
 */
function stop($data = '')
{
    if (is_array($data))
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
    else
    {
        echo $data;
    }

    exit();
}
