<?php
require_once 'DocBlockParser.php';
require_once 'YiiComponentPropertyIterator.php';
require_once 'ModelInModuleFilesIterator.php';

class Generator extends CComponent
{
    public $baseClass = 'CModel';
    public $toUndercore = false;
    public $readWriteDifferentiate = false; //phpstorm no support @property-write and @property-read specification

    public $filesIterator = 'ModelInModuleFilesIterator';
    public $propertyIterator = 'YiiComponentPropertyIterator';


    public function getFilesIterator()
    {
        return new $this->filesIterator;
    }


    public function getPropertyIterator($object)
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

            $this->addDocBlock($fileInfo);
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


    public function addDocBlock(SplFileInfo $fileInfo)
    {
        $data = $this->getInstanceByFile($fileInfo);
        if (!$data)
        {
            return false;
        }
        list($class, $object) = $data;
        $parser   = DocBlockParser::parseClass($class);
        $docBlock = $this->getDockBlock($parser, $this->getPropertyIterator($object));
        dump($docBlock);
        $file        = $fileInfo->getPath() . '/' . $fileInfo->getFileName();
        $content     = file_get_contents($file);
        $fileContent = substr($content, strpos($content, "class $class"));
        file_put_contents($file, '<?php' . PHP_EOL . $docBlock . PHP_EOL . $fileContent);
    }


    public function getDockBlock(DocBlockParser $parser, Iterator $props)
    {
        $docBlock = $this->getDescription($parser, $props);
        $docBlock .= $this->getParameters($parser, $props);
        $docBlock .= $this->getAuthors($parser, $props);

        //add commets and stars :-)
        $result = "/** \n";
        foreach (explode("\n", $docBlock) as $line)
        {
            $result .= " * " . trim($line) . "\n";
        }
        return $result . " */\n";
    }


    protected function getAuthors(DocBlockParser $parser, Iterator $props)
    {
        $docBlock = "";
        //authors
        if ($parser->authors)
        {
            foreach (explode("\n", $parser->authors) as $line)
            {
                $docBlock .= "@author $line\n";
            }
        }
        return $docBlock;
    }


    protected function getDescription(DocBlockParser $parser, Iterator $props)
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
        return $docBlock;
    }


    protected function getParameters(DocBlockParser $parser, Iterator $props)
    {
        $docBlock = "";
        //properties
        foreach ($props as $prop => $data)
        {
            $parameter = $this->toUndercore ? Yii::app()->text->camelCaseToUnderscore($prop) : $prop;

            //not use @property-write/@property-read
            if (!$this->readWriteDifferentiate)
            {
                $docBlock .= $this->getOneLine($props, $parameter);
                continue;
            }

            //use it
            $fullAccess   = $data['settable'] && $data['gettable'];
            $sameType     = $data['writeType'] == $data['readType'];
            $sameDescribe = $data['writeComment'] == $data['readComment'];
            if ($fullAccess && $sameType && $sameDescribe)
            {
                $docBlock .= $this->getOneLine($props, $parameter);
            }
            else
            {
                if ($data['settable'])
                {
                    $docBlock .= $this->getOneLine($props, $parameter, 'write');
                }
                if ($data['gettable'])
                {
                    $docBlock .= $this->getOneLine($props, $parameter, 'read');
                }
            }
        }
        $docBlock .= "\n";
        return $docBlock;
    }

    protected function getMaxLenOfType()
    {

    }

    public function getOneLine(Iterator $props, $parameter, $mode = null)
    {
        $data = $props[$parameter];

        $commentKey   = $mode ? $mode . "Comment" : 'readComment';
        $typeKey      = $mode ? $mode . "Type" : 'readType';
        $propertyType = $mode ? 'property-' . $mode : "property";

        $comment    = $data[$commentKey] ? $data[$commentKey] : $data['oldComment'];
        $type       = $data[$typeKey] ? $data[$typeKey] : $data['oldType'];

        if (strlen($type) < $props->getMaxLenOfType())
        {
            $type = $type . str_repeat(' ', $props->getMaxLenOfType() - strlen($type));
        }
        return "@$propertyType $type \$$parameter $comment\n";
    }
}
