<?php
class DocBlockCommand extends CConsoleCommand
{
    /**
     * Name of config, you can add to configs folder your config, and use it trought parameter
     *
     * @var string
     */
    public $config = 'stdConfig';

    protected $baseClass = 'CComponent';
    protected $filesIterator;
    protected $propertyIteratorOptions;
    protected $propertyOptions;
    protected $methodOptions;
    protected $messageSource;

    protected $_alias;


    /**
     * Import all needed classes
     */
    public function init()
    {
        $this->_alias = md5(__DIR__);
        Yii::setPathOfAlias($this->_alias, __DIR__);

        //configuring
        $config = require Yii::getPathOfAlias($this->_alias . '.configs.' . $this->config) . '.php';
        foreach ($config as $key => $val)
        {
            $this->$key = $val;
        }

        //do import
        Yii::import($this->_alias . '.*', true);
        Yii::import($this->_alias . '.iterators.*', true);

        //set translaitor
        Yii::app()->setComponent('docBlockMessage', Yii::createComponent($this->messageSource));
        parent::init();
    }


    /**
     * @param $object
     *
     * @return Iterator by property of file
     */
    protected function getPropertyIterator($object)
    {
        $class = $this->propertyIteratorOptions['class'];
        $this->propertyIteratorOptions['object'] = $object;
        return new $class($this->propertyIteratorOptions);
    }


    /**
     * Run processing of all files
     */
    public function actionIndex()
    {
        foreach (new $this->filesIterator as $fileInfo)
        {
            if (!$fileInfo->isFile())
            {
                continue;
            }
            $class = $this->getClassByFile($fileInfo);
            $object = $this->getClassInstance($class);
            if (!$object)
            {
                continue;
            }
            $docBlock    = $this->getDockBlock($class, $object);
            $file        = $fileInfo->getPath() . '/' . $fileInfo->getFileName();
            $content     = file_get_contents($file);
            $fileContent = substr($content, strpos($content, "class $class"));
            file_put_contents($file, '<?php' . PHP_EOL . $docBlock . PHP_EOL . $fileContent);
        }
    }


    /**
     * @param SplFileInfo $fileInfo
     *
     * @return array()|bool return class and instance by SplFileInfo or false if can't instanciate it
     */
    protected function getClassByFile(SplFileInfo $fileInfo)
    {
        return pathinfo($fileInfo->getFilename(), PATHINFO_FILENAME);
    }


    protected function getClassInstance($class)
    {
        try
        {
            $object = new $class;
            if (!$object instanceof $this->baseClass)
            {
                return false;
            }
        } catch (Exception $e)
        {
            return false;
        }
        return $object;
    }


    /**
     * @param $class
     * @param $object
     *
     * @return string final dockBlock
     */
    protected function getDockBlock($class, $object)
    {
        $props  = $this->getPropertyIterator($object);
        $parser = DocBlockParser::parseClass($class);

        //add commets and stars :-)
        $result = "/** \n";
        foreach (explode("\n", $this->getRawDockBlock($parser, $props)) as $line)
        {
            $result .= " * " . trim($line) . "\n";
        }
        return $result . " */\n";
    }


    /**
     * @param DocBlockParser $parser
     * @param Iterator       $props
     *
     * @return string docBlock without stars, only text
     */
    protected function getRawDockBlock(DocBlockParser $parser, Iterator $props)
    {
        $docBlock = "";

        //description
        if ($parser->shortDescription)
        {
            $docBlock .= $parser->shortDescription . "\n\n";
        }
        if ($parser->longDescription)
        {
            $docBlock .= $parser->longDescription . "\n\n";
        }

        //properties
        $docBlock .= implode(iterator_to_array($props));

        //other
        foreach ($parser->other as $type => $line)
        {
            $docBlock .= "@$type $line\n";
        }
        return $docBlock;
    }
}
