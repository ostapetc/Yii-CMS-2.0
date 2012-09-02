<?php
require 'DocBlockParser.php';

class Generator extends CComponent
{
    public $baseClass = 'CModel';


    public function generate()
    {
        foreach (Yii::app()->getModules() as $id => $data)
        {
            $modelsDir = Yii::app()->getModule($id)->getBasePath() . '/models';
            if (!is_dir($modelsDir) || $id == 'docs')
            {
                continue;
            }

            $models = new RecursiveDirectoryIterator($modelsDir, FilesystemIterator::SKIP_DOTS);
            foreach ($models as $fileInfo)
            {
                if (!$fileInfo->isFile())
                {
                    continue;
                }

                $this->addDocBlockFile($fileInfo);
            }
        }
    }


    public function addDocBlockFile($fileInfo)
    {
        try
        {
            $class = pathinfo($fileInfo->getFilename(), PATHINFO_FILENAME);
            $model = new $class;
            if (!$model instanceof $this->baseClass)
            {
                return false;
            }
        } catch (Exception $e)
        {
            return false;
        }

        $attributes = $this->getObjectAttributes($model);
        $setters    = $this->getSettableAndGettableProperties($model);
        $events     = $this->getEvents($model);
        $props      = array_keys(array_merge($attributes, $setters, $events));
        $result     = array();
        foreach ($props as $prop)
        {
            $result[$prop] = $this->populateProperty($model, $prop);
        }
        $parser = DocBlockParser::parseClass($class);
        $docBlock = $this->getDockBlock($parser, $result);
        dump($docBlock);
        $file        = $fileInfo->getPath() . '/' . $fileInfo->getFileName();
        $content     = file_get_contents($file);
        $fileContent = substr($content, strpos($content, "class $class"));
        file_put_contents($file, '<?php' . PHP_EOL . $docBlock . PHP_EOL . $fileContent);
    }


    public function getObjectAttributes($object)
    {
        return $object->getAttributes();
    }


    public function getSettableAndGettableProperties($object)
    {
        $props = array();
        foreach (get_class_methods($object) as $method)
        {
            if (strncasecmp($method, 'set', 3) === 0 && strncasecmp($method, 'get', 3) === 0)
            {
                $props[substr($method, 3)] = true;
            }
        }

        if (method_exists($object, 'behaviors'))
        {
            foreach ($object->behaviors() as $id => $data)
            {
                $props = array_merge($setters, $this->getSettableAndGettableProperties($object->asa($id)));
            }
        }
        return $props;
    }

    public function getEvents($object)
    {
        $events = array();
        foreach (get_class_methods($object) as $method)
        {
            if (strncasecmp($method, 'on', 2) === 0)
            {
                $events[substr($method, 2)] = true;
            }
        }
        return $events;
    }

    public function isSettable($object, $prop)
    {
        $settable = property_exists($object, $prop);
        if (!$settable && method_exists($object,'set'.$prop))
        {
            $m = new ReflectionMethod($object, 'set'.$prop);
            $settable = $m->getNumberOfRequiredParameters() <= 1;
        }
        if (!$settable && method_exists($object,'on'.$prop))
        {
            $settable = true;
        }
        return $settable;
    }

    public function isGettable($object, $prop)
    {
        $gettable = property_exists($object, $prop);
        if (!$gettable && method_exists($object,'get'.$prop))
        {
            $m = new ReflectionMethod($object, 'get'.$prop);
            $gettable = $m->getNumberOfRequiredParameters() == 0;
        }
        if (!$gettable && method_exists($object,'on'.$prop))
        {
            $gettable = true;
        }
        return $gettable;
    }

    public function getTypeAndComment($object, $prop)
    {
        $info = array(
            'getterType' => false,
            'setterType' => false,
            'getterComment' => false,
            'setterComment' => false,
        );
        if (property_exists($object, $prop))
        {
            $data = DocBlockParser::parseProperty($object, $prop)->var;
            $info['getterType'] = $info['setterType'] = $data['type'];
            $info['getterComment'] = $info['setterComment'] = $data['comment'];
        }
        if (method_exists($object, 'set'.$prop))
        {
            //no return - just first param
            $data = DocBlockParser::parseMethod($object, 'set'.$prop)->return;
            $info['setterType'] = $data['type'];
            $info['setterComment'] = $data['comment'];
        }
        if (method_exists($object, 'get'.$prop))
        {
            $data = DocBlockParser::parseMethod($object, 'get'.$prop)->return;
            $info['getterType'] = $data['type'];
            $info['getterComment'] = $data['comment'];
        }
        if (method_exists($object, 'on'.$prop))
        {
            $parser = DocBlockParser::parseMethod($object, 'on'.$prop);
            if (!$info['setterType'])
            {
                $info['type'] = "callback";
            }
            if (!$info['getterType'])
            {
                $info['type'] = "CList";
            }
            $info['setterComment'] = $parser->getShortDescription();
//            it add describe of getter, but increce size of DocBlock
//            $info['getterComment'] = 'return list of events';
        }
        return $info;
    }

    public function populateProperty($object, $prop)
    {
        $tmp = $this->getTypeAndComment($object, $prop);
        $res = array(
            'settable' => $this->isSettable($object, $prop),
            'gettable' => $this->isGettable($object, $prop),
            'setterType'     => $tmp['setterType'],
            'getterType'     => $tmp['getterType'],
            'setterComment'  => $tmp['setterComment'],
            'getterComment'  => $tmp['getterComment']
        );

        if (method_exists($object, 'behaviors'))
        {
            foreach ($object->behaviors() as $id => $data)
            {
                $data = $this->populateProperty($object->asa($id), $prop);
                $res  = array(
                    'settable' => $res['settable'] || $data['settable'],
                    'gettable' => $res['gettable'] || $data['gettable'],
                );
                foreach (array('setterType', 'getterType', 'setterComment', 'getterComment') as $key)
                {
                    $res[$key] = $res[$key] ? $res[$key] : $data[$key];
                }
            }
        }
        return $res;
    }

    public function getDescr(DocBlockParser $parser)
    {
        $docBlock = '';
        if ($parser->shortDescription)
        {
            foreach (explode("\n", $parser->shortDescription) as $line)
            {
                $docBlock .= " * ".trim($line, "\r")."\n";
            }
            $docBlock .= " * \n";
        }
        if ($parser->longDescription)
        {
            foreach (explode("\n", $parser->longDescription) as $line)
            {
                $docBlock .= " * ".trim($line, "\r")."\n";
            }
            $docBlock .= " * \n";
        }

        return $docBlock;
    }

    public function getDockBlock(DocBlockParser $parser, $props)
    {
        $docBlock = "/** \n";
        $docBlock .= $this->getDescr($parser);

        foreach ($props as $prop => $data)
        {
            $name         = Yii::app()->text->camelCaseToUnderscore($prop);

            if ($data['settable'] && $data['gettable'] && ($data['setterType'] == $data['getterType']) && ($data['setterComment'] == $data['getterComment']))
            {
                $docBlock .= $this->getOneLine($parser, $name, null, $data);
            }
            else
            {
                if ($data['settable'])
                {
                    $docBlock .= $this->getOneLine($parser, $name, 'write', $data);
                }
                if ($data['gettable'])
                {
                    $docBlock .= $this->getOneLine($parser, $name, 'read', $data);
                }
            }
        }
        $docBlock .= " * \n";

        if ($parser->authors)
        {
            foreach (explode("\n", $parser->authors) as $line)
            {
                $docBlock .= " * @author $line\n";
            }
            $docBlock .= " * \n";
        }

        $docBlock .= " */\n";
        return $docBlock;
    }

    public function getOneLine(DocBlockParser $parser, $name, $mode, $data)
    {
        switch($mode)
        {
            case 'write':
                $propertyType = "property-write";
                $commentKey = 'setterComment';
                $typeKey = 'setterType';
                $nameKey = $name.'-write';
                break;
            case 'read':
                $propertyType = "property-read";
                $commentKey = 'getterComment';
                $typeKey = 'getterType';
                $nameKey = $name.'-read';
                break;
            default:
                $propertyType = "property";
                $commentKey = 'getterComment';
                $typeKey = 'getterType';
                $nameKey = $name;
                break;
        }
        $oldComment = isset($parser->properties[$nameKey]) ? $parser->properties[$nameKey][$commentKey] : '';
        $comment = $data[$commentKey] ? $data[$commentKey] : $oldComment;
        $oldType =  isset($parser->properties[$nameKey]) ? $parser->properties[$nameKey][$typeKey] : '';
        $type = $data[$typeKey] ? $data[$typeKey] : $oldType;
        return " * @$propertyType $type \$$name $comment\n";
    }
}
