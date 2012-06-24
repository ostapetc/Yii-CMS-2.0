<?

abstract class ActiveRecord extends CActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_SEARCH = 'search';

    public $captcha;

    private $_meta; //full metadata of model

    abstract public function name();


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function behaviors()
    {
        return array(
            'Languages'  => array(
                'class' => 'application.components.activeRecordBehaviors.LanguagesBehavior'
            ),
            'NullValue'      => array(
                'class' => 'application.components.activeRecordBehaviors.NullValueBehavior'
            ),
            'UserForeignKey' => array(
                'class' => 'application.components.activeRecordBehaviors.UserForeignKeyBehavior'
            ),
            'UploadFile'     => array(
                'class' => 'application.components.activeRecordBehaviors.UploadFileBehavior'
            ),
            'DateFormat'     => array(
                'class' => 'application.components.activeRecordBehaviors.DateFormatBehavior'
            ),
            'Timestamp'      => array(
                'class' => 'application.components.activeRecordBehaviors.TimestampBehavior'
            ),
            'MaxMin'         => array(
                'class' => 'application.components.activeRecordBehaviors.MaxMinBehavior'
            ),
            'RawFind'         => array(
                'class' => 'application.components.activeRecordBehaviors.RawFindBehavior'
            ),
        );
    }


    public function attributeLabels()
    {
        $labels = array();

        foreach ($this->meta() as $field_data)
        {
            $labels[$field_data["Field"]] = t($field_data["Comment"]);
        }

        $languages = Language::getList();
        if (count($languages) > 1)
        {
            $labels['language'] = 'Язык';
        }
        $labels['captcha'] = 'Введите код с картинки';

        return $labels;
    }


    public function label($attribute)
    {
        $labels = $this->attributeLabels();

        if (isset($labels[$attribute]) && !empty($labels[$attribute]))
        {
            return $labels[$attribute];
        }

        return ucfirst(str_replace('_', ' ', $attribute));
    }


    public function value($attribute)
    {
        $method_name = 'format' . ucfirst(StringHelper::underscoreToCamelcase($attribute));
        if (method_exists($this, $method_name))
        {
            return $this->$method_name();
        }
        else
        {
            return $this->$attribute;
        }
    }


    public function __get($name)
    {
        try
        {
            return parent::__get($name);
        } catch (CException $e)
        {
            if (substr($name, -6) == '_label')
            {
                $attribute = substr($name, 0, -6);
                return $this->getAttributeLabel($attribute);
            }

            $method_name = StringHelper::underscoreToCamelcase($name);
            $method_name = 'get' . ucfirst($method_name);

            if (method_exists($this, $method_name))
            {
                return $this->$method_name();
            }
            else
            {
                throw new CException($e->getMessage());
            }
        }
    }


    public function __set($name, $val)
    {
        try
        {
            return parent::__set($name, $val);
        }
        catch (CException $e)
        {
            $method_name = StringHelper::underscoreToCamelcase($name);
            $method_name = 'set' . ucfirst($method_name);

            if (method_exists($this, $method_name))
            {
                return $this->$method_name($val);
            }
            else
            {
                throw new CException($e->getMessage());
            }
        }
    }


    public function __toString()
    {
        $attributes = array(
            'name', 'title', 'description', 'id'
        );

        foreach ($attributes as $attribute)
        {
            if (array_key_exists($attribute, $this->attributes))
            {
                return $this->$attribute;
            }
        }
    }


    /*___________________________________________________________________________________*/


    /*SCOPES_____________________________________________________________________________*/
    public function scopes()
    {
        $alias = $this->getTableAlias();
        return array(
            'published' => array('condition' => $alias . '.is_published = 1'),
            'sitemap'   => array('condition' => $alias . '.is_published = 1'),
            'ordered'   => array('order'     => $alias . '.`order` DESC'),
            'last'      => array('order'     => $alias . '.date_create DESC'),
        );
    }


    public function limit($num)
    {
        $this->getDbCriteria()->mergeWith(array(
            'limit' => $num,
        ));

        return $this;
    }


    public function offset($num)
    {
        $this->getDbCriteria()->mergeWith(array(
            'offset' => $num,
        ));

        return $this;
    }


    public function inArray($row, $values, $operator = 'AND')
    {
        $this->getDbCriteria()->addInCondition($row, $values, $operator);
        return $this;
    }


    public function notInArray($row, $values, $operator = 'AND')
    {
        $this->getDbCriteria()->addNotInCondition($row, $values, $operator);
        return $this;
    }


    public function notEqual($param, $value)
    {
        $alias = $this->getTableAlias();
        $this->getDbCriteria()->mergeWith(array(
            'condition' => $alias . ".`{$param}` != '{$value}'",
        ));

        return $this;
    }


    public function meta()
    {
        if ($this->_meta == null);
        {
            $this->_meta = Yii::app()->db->cache(YII_DEBUG ? 0 : 3600)->createCommand("SHOW FUll columns FROM " . $this->tableName())->queryAll();
        }
        return $this->_meta;
    }


    public function optionsTree($name = 'name', $id = null, $result = array(), $value = 'id', $spaces = 0, $parent_id = null)
    {
        $objects = $this->findAllByAttributes(
            array('parent_id' => $parent_id),
            array('order'     => 'parent_id')
        );

        foreach ($objects as $object)
        {
            if ($object->id == $id)
            {
                continue;
            }

            $result[$object->$value] = str_repeat(".", $spaces) . $object->$name;

            if ($object->childs)
            {
                $result = $this->optionsTree($name, $id, $result, $value, $spaces+2, $object->id);
            }
        }

        return $result;
    }


    /**
     * @param CModelEvent $event
     */
    public function onBeforeFormInit($event)
    {
        $this->raiseEvent('onBeforeFormInit', $event);
    }

    /**
     * @param CModelEvent $event
     */
    public function onAfterFormInit($event)
    {
        $this->raiseEvent('onAfterFormInit', $event);
    }

    /**
     * @param CModelEvent $event
     */
    public function onBeforeGridInit($event)
    {
        $this->raiseEvent('onAfterGridInit', $event);
    }

    /**
     * @param CModelEvent $event
     */
    public function onAfterGridInit($event)
    {
        $this->raiseEvent('onAfterGridInit', $event);
    }

    /**
     * @param CModelEvent $event
     */
    public function onBeforeGridInitColumns($event)
    {
        $this->raiseEvent('onBeforeGridInitColumns', $event);
    }

    /**
     * @param CModelEvent $event
     */
    public function onAfterGridInitColumns($event)
    {
        $this->raiseEvent('onAfterGridInitColumns', $event);
    }


    public function getErrorsArray()
    {
        $array = array();

        foreach ($this->errors as $attr => $errors)
        {
            $array = array_merge($array, $errors);
        }

        return $array;
    }

    public function getNewAttachedModel($model_class)
    {
        $attach = new $model_class();
        $attach->model_id = get_class($this);
        if ($this->getIsNewRecord())
        {
            $attach->object_id = 'tmp_' . get_class($this) . '_' . Yii::app()->user->id;
        }
        else
        {
            $attach->object_id = $this->getPrimaryKey();
        }

        return $attach;
    }

}
