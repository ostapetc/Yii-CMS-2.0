<?php
require 'DocBlockParser.php';

class Generator extends CComponent
{
    public $baseClass = 'CModel';
    public $toUndercore = false;


    public function getIterator()
    {
        $iterator = new AppendIterator();
        foreach (Yii::app()->getModules() as $id => $data)
        {
            $modelsDir = Yii::app()->getModule($id)->getBasePath() . '/models';
            if (!is_dir($modelsDir) || $id == 'docs')
            {
                continue;
            }
            $iterator->append(new RecursiveDirectoryIterator($modelsDir, FilesystemIterator::SKIP_DOTS));
        }
        return $iterator;
    }


    public function generate()
    {
        foreach ($this->getIterator() as $fileInfo)
        {
            if (!$fileInfo->isFile())
            {
                continue;
            }

            $this->addDocBlockFile($fileInfo);
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
        $setters    = $this->getSettersAndGetters($model);
        $events     = $this->getEvents($model);
        $props      = array_keys(array_merge($attributes, $setters, $events));
        $props      = $this->filter($model, $props);
        $result     = array();
        foreach ($props as $prop)
        {
            $result[$prop] = $this->populateProperty($model, $prop);
        }
        $parser   = DocBlockParser::parseClass($class);
        $docBlock = $this->getDockBlock($parser, $result);
        $file        = $fileInfo->getPath() . '/' . $fileInfo->getFileName();
        $content     = file_get_contents($file);
        $fileContent = substr($content, strpos($content, "class $class"));
        file_put_contents($file, '<?php' . PHP_EOL . $docBlock . PHP_EOL . $fileContent);
    }

    public function filter($class, $props)
    {
        while($class = get_parent_class($class))
        {
            $parentProps = array_keys(DocBlockParser::parseClass($class)->properties);
            array_map(function($item) {
                return strtr($item, array('-write'=>'', '-read'=>''));
            }, $parentProps);
            $props = array_diff($props, $parentProps);
        }
        return $props;
    }

    public function getObjectAttributes($object)
    {
        return $object->getAttributes();
    }


    public function getSettersAndGetters($object)
    {
        $props = array();
        foreach (get_class_methods($object) as $method)
        {
            if (strncasecmp($method, 'set', 3) === 0 || strncasecmp($method, 'get', 3) === 0)
            {
                $props[lcfirst(substr($method, 3))] = true;
            }
        }

        if (method_exists($object, 'behaviors'))
        {
            foreach ($object->behaviors() as $id => $data)
            {
                $props = array_merge($props, $this->getSettersAndGetters($object->asa($id)));
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
                $events[$method] = true;
            }
        }
        return $events;
    }


    public function isSettable($object, $prop)
    {
        $settable = property_exists($object, $prop);
        if (!$settable && method_exists($object, 'set' . $prop))
        {
            $m        = new ReflectionMethod($object, 'set' . $prop);
            $settable = $m->getNumberOfRequiredParameters() <= 1;
        }
        if (!$settable && method_exists($object, 'on' . $prop))
        {
            $settable = true;
        }
        return $settable;
    }


    public function isGettable($object, $prop)
    {
        $gettable = property_exists($object, $prop);
        if (!$gettable && method_exists($object, 'get' . $prop))
        {
            $m        = new ReflectionMethod($object, 'get' . $prop);
            $gettable = $m->getNumberOfRequiredParameters() == 0;
        }
        if (!$gettable && method_exists($object, 'on' . $prop))
        {
            $gettable = true;
        }
        return $gettable;
    }


    public function getTypeAndComment($object, $prop)
    {
        $info = array(
            'readType'     => false,
            'writeType'    => false,
            'readComment'  => false,
            'writeComment' => false,
        );
        if (property_exists($object, $prop))
        {
            $data                = DocBlockParser::parseProperty($object, $prop)->var;
            $info['readType']    = $info['writeType'] = $data['type'];
            $info['readComment'] = $info['writeComment'] = $data['comment'];
        }
        if (method_exists($object, 'set' . $prop))
        {
            $data                 = DocBlockParser::parseMethod($object, 'set' . $prop)->params;
            $first                = array_shift($data); //get first param of setter
            $info['writeType']    = $first['type'];
            $info['writeComment'] = $first['comment'];
        }
        if (method_exists($object, 'get' . $prop))
        {
            $data                = DocBlockParser::parseMethod($object, 'get' . $prop)->return;
            $info['readType']    = $data['type'];
            $info['readComment'] = $data['comment'];
        }
        if (method_exists($object, 'on' . $prop))
        {
            $parser               = DocBlockParser::parseMethod($object, 'on' . $prop);
            $info['writeType']    = $info['readType'] = "CList";
            $info['writeComment'] = $info['readComment']  = $parser->getShortDescription();
        }
        return $info;
    }


    public function populateProperty($object, $prop)
    {
        $res = array(
            'settable'      => $this->isSettable($object, $prop),
            'gettable'      => $this->isGettable($object, $prop),
        );
        $res = CMap::mergeArray($res, $this->getTypeAndComment($object, $prop));

        if (method_exists($object, 'behaviors'))
        {
            foreach ($object->behaviors() as $id => $data)
            {
                $data = $this->populateProperty($object->asa($id), $prop);
                $res['settable'] = $res['settable'] || $data['settable'];
                $res['gettable'] = $res['gettable'] || $data['gettable'];
                $keys = array(
                    'writeType',
                    'readType',
                    'writeComment',
                    'readComment'
                );
                foreach ($keys as $key)
                {
                    $res [$key] =
                        $res[$key] ? $res[$key] :
                            $data[$key];
                }
            }
        }
        return $res;
    }


    public function getDockBlock(DocBlockParser $parser, $props)
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
        foreach ($props as $prop => $data)
        {
            $name = $this->toUndercore ? Yii::app()->text->camelCaseToUnderscore($prop) : $prop;

            if ($data['settable'] && $data['gettable'] && ($data['writeType'] == $data['readType']) &&
                ($data['writeComment'] == $data['readComment'])
            )
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
        $docBlock .= "\n";

        //authors
        if ($parser->authors)
        {
            foreach (explode("\n", $parser->authors) as $line)
            {
                $docBlock .= "@author $line\n";
            }
        }

        //add commets and stars :-)
        $result = "/** \n";
        foreach (explode("\n", $docBlock) as $line)
        {
            $result .= " * " . trim($line) . "\n";
        }
        return $result . " */\n";
    }


    public function getOneLine(DocBlockParser $parser, $name, $mode, $data)
    {
        $commentKey   = $mode ? $mode . "Comment" : 'writeComment';
        $typeKey      = $mode ? $mode . "Type" : 'writeType';
        $nameKey      = $mode ? $name . '-' . $mode : $name;
        $propertyType = $mode ? 'property-' . $mode : "property";

        $oldComment = isset($parser->properties[$nameKey]) ? $parser->properties[$nameKey]['comment'] : '';
        $comment    = $data[$commentKey] ? $data[$commentKey] : $oldComment;
        $oldType    = isset($parser->properties[$nameKey]) ? $parser->properties[$nameKey]['type'] : '';
        $type       = $data[$typeKey] ? $data[$typeKey] : $oldType;
        return "@$propertyType $type \$$name $comment\n";
    }
}
