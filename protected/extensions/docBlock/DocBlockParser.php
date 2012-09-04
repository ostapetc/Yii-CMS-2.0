<?php
/**
 * @property-read array  $other
 * @property-read string $shortDescription
 * @property-read string $longDescription
 * @property-read array  $params
 * @property-read string $return
 * @property-read array  $properties
 */
class DocBlockParser extends CComponent
{
    protected $shortDescription, $longDescription, $var, $params = array(), $properties = array(), $other = array(), $return, $licence, $link, $todo;


    private function __construct($docBlock)
    {
        $this->parse($docBlock);
    }


    public static function parseClass($class)
    {
        $ref = new ReflectionClass($class);
        return new static($ref->getDocComment());
    }


    public static function parseMethod($class, $method)
    {
        $ref = new ReflectionMethod($class, $method);
        return new static($ref->getDocComment());
    }


    public static function parseProperty($class, $property)
    {
        $ref = new ReflectionProperty($class, $property);
        return new static($ref->getDocComment());
    }


    /**
     * Parses the given doc block
     *
     * The annotations
     *
     * @param, @author, @return and the descriptions (short and long) will be parsed
     *
     * @param string docBlock
     */
    public function parse($docBlock)
    {
        $lines = $this->cleanupDocBlock($docBlock);

        foreach ($lines as $line)
        {
            if ($line)
            {
                $this->tryProperties($line) || $this->tryParams($line) || $this->tryVar($line) ||
                    $this->tryReturn($line) || $this->tryOther($line) || $this->tryDescr($line);
            }
        }
    }


    protected function tryDescr($line)
    {
        if (!preg_match('/@\w+/', $line))
        {
            if (is_null($this->shortDescription))
            {
                $this->shortDescription = $line;
            }
            else
            {
                $this->longDescription .= $line . "\n";
            }
            return true;
        }
        return false;
    }


    protected function tryParams($line)
    {
        if (preg_match('/@param(\s+([^ ]+))?\s+\$([^ ]+)(\s+(.*))?/', $line, $match))
        {
            $this->params[$match[3]] = array(
                'type'        => $match[2],
                'comment'     => isset($match[5]) ? $match[5] : '',
            );
            return true;
        }
        return false;
    }


    protected function tryOther($line)
    {
        if (preg_match('/@(author|api|category|deprecated|example|filesource|ignore|internal|license|link|package|see|since|subpackage|todo|version|uses|used-by)\s+(.*)/',
            $line, $match)
        )
        {
            $this->other[$match[1]] = $match[2];
            return true;
        }
        return false;
    }


    protected function tryReturn($line)
    {
        if (preg_match('/@return\s+([^ ]+)\s*(.*)/', $line, $match))
        {
            $this->return = array(
                'type'    => $match[1],
                'comment' => $match[2]
            );
            return true;
        }
        return false;
    }


    protected function tryVar($line)
    {
        if (preg_match('/@var(\s+([^ ]+))?(\s+(.*))?/', $line, $match))
        {
            $this->var = array(
                'type'    => isset($match[2]) ? $match[2] : '',
                'comment' => isset($match[4]) ? $match[4] : '',
            );
            return true;
        }
        return false;
    }


    protected function tryProperties($line)
    {
        if (preg_match('/@property(|-read|-write)(\s+([^ ]+))?\s+\$([^ ]+)(\s+(.*))?/', $line, $match))
        {
            $this->properties[$match[4] . $match[1]] = array(
                'type'    => $match[3],
                'comment' => isset($match[6]) ? $match[6] : '',
            );
            return true;
        }
        return false;
    }


    /**
     * Returns the short description
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }


    public function getVar()
    {
        return $this->var;
    }


    /**
     * Returns the long description
     *
     * @return string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }


    /**
     * Returns the function or method parameters
     *
     * @param  array $params Array of ReflectionParameters
     *
     * @return array Array of parameters
     */
    public function getParams($params = array())
    {
        if (count($params))
        {
            foreach ($params as $reflectionParam)
            {
                if (!isset($this->params['$' . $reflectionParam->getName()]))
                {
                    $param        = array(
                        '$' . $reflectionParam->getName() => array(
                            'type'        => '',
                            'description' => ''
                        )
                    );
                    $this->params = array_merge($this->params, $param);
                }
            }
        }

        return $this->params;
    }


    /**
     * Returns the function or method parameters
     *
     * @param  array $params Array of ReflectionParameters
     *
     * @return array Array of parameters
     */
    public function getProperties($props = array())
    {
        return $this->properties;
    }


    /**
     * Returns the
     *
     * @return parameter
     *
     * @return array
     */
    public function getReturn()
    {
        return $this->return;
    }


    /**
     * Returns the other tags
     *
     * @return array
     */
    public function getOther()
    {
        return $this->other;
    }


    /**
     * Clean the given doc block
     *
     * @param  string $docBlock
     *
     * @return string
     */
    protected function cleanupDocBlock($docBlock)
    {
        $docBlock = preg_replace(array(
            '#^\s*/\*\*\s*#',
            # doc start /**
            '#^\s*\*/\s*#',
            # doc end */
            '#^\s*\*\s?#',
            # doc line *
            '#\s*$#'
            # trim spaces
        ), '', explode("\n", $docBlock));

        return $docBlock;
    }
}