<?php
require_once 'DocBlockParser.php';
require_once 'YiiComponentPropertyIterator.php';
require_once 'ModelInModuleFilesIterator.php';
require_once 'YiiComponentProperty.php';

class Generator extends CComponent
{
    public $baseClass = 'CComponent';
    public $readWriteDifferentiate = true; //phpstorm no support @property-write and @property-read specification

    public $filesIterator = 'ModelInModuleFilesIterator';
    public $propertyIterator = 'YiiComponentPropertyIterator';


    protected function getFilesIterator()
    {
        return new $this->filesIterator;
    }


    protected function getPropertyIterator($object)
    {
        $class = $this->propertyIterator;
        return new $class($object);
    }


    public function generate()
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
            dump($docBlock  );
            $file        = $fileInfo->getPath() . '/' . $fileInfo->getFileName();
            $content     = file_get_contents($file);
            $fileContent = substr($content, strpos($content, "class $class"));
            file_put_contents($file, '<?php' . PHP_EOL . $docBlock . PHP_EOL . $fileContent);
        }
    }


    public function getInstanceByFile(SplFileInfo $fileInfo)
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


    public function getDockBlock($class, CComponent $object)
    {
        $props = $this->getPropertyIterator($object);
        $parser = DocBlockParser::parseClass($class);

        //add commets and stars :-)
        $result = "/** \n";
        foreach (explode("\n", $this->getRawDockBlock($parser, $props)) as $line)
        {
            $result .= " * " . trim($line) . "\n";
        }
        return $result . " */\n";
    }

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
        foreach ($props as $prop)
        {
            $docBlock .= $prop;
        }

        //other
        foreach ($parser->other as $type => $line)
        {
            $docBlock .= "@$type $line\n";
        }
        return $docBlock;
    }
}
