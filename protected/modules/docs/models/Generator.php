<?php
class Generator extends CComponent
{

    public function generate()
    {
        //        $dock_block = new Zend_CodeGenerator_Php_Docblock();
        foreach (Yii::app()->getModules() as $id => $data)
        {
            $modelsDir = Yii::app()->getModule($id)->getBasePath() . '/models';
            if (!is_dir($modelsDir))
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
            if (!$model instanceof CModel)
            {
                return false;
            }
        }
        catch (Exception $e)
        {
            return false;
        }

        $attributes = $this->getObjectAttributes($model);
        $setters = $this->getSettableProperties($model);
        $events = $this->getEvents($model);
        $props = array_keys(array_merge($attributes, $setters, $events));
        $result = array();
        foreach ($props as $prop)
        {
            $result[$prop] = $this->populateProperty($model,$prop);
        }
        $dockBlock = $this->getDockBlock($result);
        $file = $fileInfo->getFileName().'/'.$fileInfo->getFileName();
        $content = file_get_contents($file);
        $fileContent = substr($content, strpos($content, 'class '));
        file_put_contents($file,'<?php' . PHP_EOL . $docBlock . PHP_EOL . $fileContent);
    }

    public function getObjectAttributes($object)
    {
        return $object->getAttributes();
    }

    public function getSettableProperties($object)
    {
        $setters    = array();
        foreach (get_class_methods($object) as $method)
        {
            if (strncasecmp($method, 'set', 3) === 0)
            {
                $setters[substr($method, 3)] = true;
            }
        }

        if (method_exists($object, 'behaviors'))
        {
            foreach ($object->behaviors() as $id => $data)
            {
                $setters = array_merge($setters, $this->getSettableProperties($object->asa($id)));
            }
        }
        return $setters;
    }

    public function getEvents($object)
    {
        $events = array();
        foreach (get_class_methods($object) as $method)
        {
            if (strncasecmp($method, 'on', 2) === 0)
            {
                $setters[substr($method, 2)] = true;
            }
        }
        return $events;
    }

    public function populateProperty($object, $prop)
    {
        $res = array(
            'settable' => property_exists($object, $prop) || $object->canSetProperty($prop),
            'gettable' => property_exists($object, $prop) || $object->canGetProperty($prop),
            'type' => null,
            'comment' => null
        );

        if (method_exists($object, 'behaviors'))
        {
            foreach ($object->behaviors() as $id => $data)
            {
                $data = $this->populateProperty($object->asa($id), $prop);
                $res = array(
                    'settable' => $res['settable'] || $data['settable'],
                    'gettable' => $res['gettable'] || $data['gettable'],
                    'type' => $res['type'] ? $res['type'] : $data['type'],
                    'comment' => $res['comment'] ? $res['comment'] : $data['comment'],
                );
            }
        }
        return $res;
    }


    public function getDockBlock($props)
    {
        $dockBlock = "/** Autogeneratable \n";
        $dockBlock .= " * \n";

        foreach ($props as $prop => $data)
        {
            $name = Yii::app()->text->camelCaseToUnderscore($prop);
            $propertyType = false;

            if ($data['settable'] && $data['gettable'])
            {
                $propertyType = 'property';
            }
            elseif ($data['settable'])
            {
                $propertyType = 'property-write';
            }
            elseif ($data['gettable'])
            {
                $propertyType = 'property-read';
            }
            if ($propertyType)
            {
                $dockBlock .= " * @$propertyType {$data['type']} $name {$data['comment']} \n";
            }
        }
        $dockBlock .= " */\n";
        return $dockBlock;
    }
}