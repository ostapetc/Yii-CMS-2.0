<?

function p($data)
{
    echo '<pre>';
    CVarDumper::dump($data, 1000, false);
    echo '</pre>';
}


function v($data)
{
    echo "<pre>" . var_dump($data) . "</pre>";
}


if (function_exists('get_called_class') === false)
{
    function get_called_class()
    {
        $bt    = debug_backtrace();
        $lines = file($bt[1]['file']);
        preg_match('/([a-zA-Z0-9\_]+)::' . $bt[1]['function'] . '/', $lines[$bt[1]['line'] - 1], $matches);
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
    $translated_message = Yii::t('main', $message);
    if ($translated_message != $message)
    {
        return $translated_message;
    }

    $messages = LanguageMessage::getList();
    if (!in_array($message, $messages))
    {
        $language_message = new LanguageMessage();
        $language_message->message  = $message;
        $language_message->category = LanguageMessage::DEFAULT_CATEGORY;
        //$language_message->save();
    }

    return $message;
}

//для работы моих отладочных функций нужны 2 переменных, мне их глобальными объявлять?
class Y extends CComponent
{
    private static $startSkipCount = 0;
    private static $skipCount = 0;


    /**
     * Ярлык для функции dump класса CVarDumper для отладки приложения
     *
     * @param mixed   $var   переменная для вывода
     * @param boolean $toDie остановить ли дальнейшее выполнение приложения, по умолчанию - true
     */
    public static function dump($var, $skipCount = 0, $depth = 2)
    {
        if (self::$startSkipCount == 0) {
            self::$startSkipCount = self::$skipCount = $skipCount;
        }
        else
        {
            self::$skipCount--;
        }

        if (self::$skipCount == 0)
        {
            self::$startSkipCount = 0;

            echo '<pre>';
            CVarDumper::dump($var, $depth, true);
            echo '</pre>';

            exit();
        }
    }


    /**
     * Выводит текст и завершает приложение (применяется в ajax-действиях)
     *
     * @param string $text текст для вывода
     */
    public static function end($data = '')
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
}