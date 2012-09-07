<?php
class DocBlockCommand extends CConsoleCommand
{
    public $baseClass = 'CComponent';
    public $readWriteDifferentiate = true; //phpstorm no support @property-write and @property-read specification

    public $filesIterator = 'ModelInModuleFilesIterator';
    public $propertyIterator = 'YiiComponentPropertyIterator';

    public $propertyIteratorOptions = array(
        'commentLanguage'   => 'ru',
        'includeAttributes' => true,
        'includeEvents'     => false,
        'includeAccessors'  => true,
        'includeRelations'  => true
    );

    public $propertyOptions = array(
        'class'                     => 'YiiComponentProperty',
        'toUndercore'               => false,
        'readWriteDifferentiate'    => false,
        'tagVerticalAlignment'      => true,
        'typeVerticalAlignment'     => true,
        'propertyVerticalAlignment' => true
    );

    public $methodOptions = array(
        'class'                     => 'YiiComponentMethod',
        'toUndercore'               => false,
        'tagVerticalAlignment'      => true,
        'typeVerticalAlignment'     => true,
        'propertyVerticalAlignment' => true
    );


    /**
     * Import all needed classes
     */
    public function init()
    {
        $importClasses = array(
            'DocBlockLine',
            'DocBlockParser',
            'DocBlockComment',
            'messages.DocBlockMessageSource',
            'iterators.' . $this->propertyIterator,
            'iterators.' . $this->filesIterator,
            $this->propertyOptions['class'],
            $this->methodOptions['class']
        );

        //do import
        $alias = md5(__DIR__);
        Yii::setPathOfAlias($alias, __DIR__);
        foreach ($importClasses as $class)
        {
            Yii::import($alias . '.' . $class, true);
        }

        Yii::app()->setComponent('docBlockMessage', new DocBlockMessageSource());
        parent::init();
    }


    /**
     * @return Iterator by Files for processing
     */
    protected function getFilesIterator()
    {
        return new $this->filesIterator;
    }


    /**
     * @param $object
     *
     * @return Iterator by property of file
     */
    protected function getPropertyIterator($object)
    {
        $class = $this->propertyIterator;
        return new $class($this->propertyIteratorOptions, $object, $this->propertyOptions, $this->methodOptions);
    }


    /**
     * Run processing of all files
     */
    public function actionGenerate()
    {
        foreach ($this->getFilesIterator() as $fileInfo)
        {
            if (!$fileInfo->isFile())
            {
                continue;
            }

            $data = $this->getInstanceByFile($fileInfo);
            if (!$data)
            {
                continue;
            }
            list($class, $object) = $data;
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
    protected function getInstanceByFile(SplFileInfo $fileInfo)
    {
        try
        {
            $class  = pathinfo($fileInfo->getFilename(), PATHINFO_FILENAME);
            $object = new $class;
            if (!$object instanceof $this->baseClass)
            {
                return false;
            }
        } catch (Exception $e)
        {
            return false;
        }
        return array(
            $class,
            $object
        );
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
