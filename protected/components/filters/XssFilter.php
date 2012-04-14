<?
/**
 * Фильтр предназначен для фильтрации входных данных, c целью предотвратить xss атаки.
 *  Для фильтрации используются регулярные выражения из фреймворка Kohana версии 2.3.4
 *
 * @author  Opeykin A. <http://andrey.opeykin.ru> <developer@allframeworks.ru>
 * @version 0.0.2
 * @package filters
 * @example
 *
 *  public function filters()
 *  {
 *         return array(
 *                 array(
 *                       'application.filters.XssFilter',
 *                       'clean'   => '*',
 *                       'tags'    => 'strict',
 *                       'actions' => 'all'
 *                 )
 *         );
 *
 *   }
 *
 *   Описание параметров
 *
 *   В качетве параметра 'clean' могут быть:
 *  - 'all' - фильтруются GET,POST,COOKIE,FILES массивы;
 *  - '*'   - аналог ALL;
 *  - так же возможно сочетание любых из параметров, например GET,COOKIE или POST,FILES
 *   В качестве параметра 'tags' могут быть:
 *  - 'strict' - ко всем параметрам применяется функция strip_tags (используется по умолчанию)
 *  - 'soft'   - ко всем параметрам применяется функция htmlspecialchars
 *  - 'none'   - не фильтровать
 *   В качестве параметра 'actions' могут быть:
 *  - '*' или 'all' - фильтруются все экшены
 *  - можно указать экшены через запятую, пример
 *   'actions' => 'admin,manage' - фильтровать только экшены admin и manage
 */

class XssFilter extends CFilter
{

    public $clean = '*';
    public $tags = 'strict';
    public $actions = '*,all';


    protected function preFilter($filterChain)
    {
        $this->actions = trim(strtoupper($this->actions));
        // если экшн обрабатывать нет необходимости - просто выходим из фильтра
        if ($this->actions != '*' && $this->actions != 'ALL' &&
            !in_array($filterChain->action->id, explode(',', $this->actions))
        )
        {
            return true;
        }
        $this->clean = trim(strtoupper($this->clean));
        $this->tags  = trim(strtoupper($this->tags));
        $data        = array(
            'GET'    => &$_GET,
            'POST'   => &$_POST,
            'COOKIE' => &$_COOKIE,
            'FILES'  => &$_FILES
        );

        if ($this->clean === 'ALL' || $this->clean === '*')
        {
            $this->clean = 'GET,POST,COOKIE,FILES';
        }

        // по умолчанию - strict
        if (!in_array($this->tags, array('STRICT', 'SOFT', 'NONE')))
        {
            $this->tags = 'STRICT';
        }


        $dataForClean = split(',', $this->clean);
        if (count($dataForClean))
        {
            foreach ($dataForClean as $key => $value)
            {
                if (isset ($data[$value]) && count($data[$value]))
                {
                    $this->doXssClean($data[$value]);
                }
            }
        }

        return true;
    }


    private function doXssClean(&$data)
    {
        if (is_array($data) && count($data))
        {
            foreach ($data as $k => $v)
            {
                $data[$k] = $this->doXssClean($v);
            }
            return $data;
        }

        if (trim($data) === '')
        {
            return $data;
        }


        // перед фильтрацией разберемся с тегами
        switch ($this->tags)
        {
            case 'STRICT':
                $data = strip_tags($data);
                break;
            case 'SOFT':
                $data = htmlentities($data, ENT_QUOTES, 'UTF-8');
                break;
            case 'NONE':
                break;
            // по умолчанию - strict
            default:
                $data = strip_tags($data);
        }

        // xss_clean function from Kohana framework 2.3.4
        $data = str_replace(array('&', '<', '>'), array('&amp;', '&lt;', '&gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu',
            '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu',
            '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u',
            '$1=$2nomozbinding...', $data);
        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i',
            '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i',
            '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu',
            '$1>', $data);
        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
        do
        {
            // Remove really unwanted tags
            $old_data = $data;
            $data     = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i',
                '', $data);
        } while ($old_data !== $data);
        return $data;
    }

}
