<?

/**
 * @property string errors_flat_array
 */
abstract class ActiveRecord extends CActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_SEARCH = 'search';

    public $captcha;

    private $_meta; //full metadata of model

    /**
     * set by chain method throw404IfNull()
     * @var bool
     */
    protected $_throw404IfNull = false;

    /**
     * set by chain method asArray()
     * @var bool
     */
    protected $_asArray = false;

    abstract public function name();

    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
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
        $method_name = 'get' . ucfirst(Yii::app()->text->underscoreToCamelcase($attribute)) . 'Value';

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

            $method_name = Yii::app()->text->underscoreToCamelcase($name);
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
            $method_name = Yii::app()->text->underscoreToCamelcase($name);
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
    /**
     * @return self
     */
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


    /**
     * @param $num
     * @return self
     */
    public function limit($num)
    {
        $this->getDbCriteria()->mergeWith(array(
            'limit' => $num,
        ));

        return $this;
    }

    /**
     * @param $num
     * @return self
     */
    public function offset($num)
    {
        $this->getDbCriteria()->mergeWith(array(
            'offset' => $num,
        ));

        return $this;
    }


    /**
     * @param        $row
     * @param        $values
     * @param string $operator
     * @return self
     */
    public function in($row, $values, $operator = 'AND')
    {
        $this->getDbCriteria()->addInCondition($row, $values, $operator);
        return $this;
    }


    /**
     * @param        $row
     * @param        $values
     * @param string $operator
     * @return self
     */
    public function notIn($row, $values, $operator = 'AND')
    {
        $this->getDbCriteria()->addNotInCondition($row, $values, $operator);
        return $this;
    }

    /**
     * @param $param
     * @param $value
     * @return self
     */
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


    public function getAttachedModel($model_class)
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


    public function existsByAttributes($attributes)
    {
        $criteria = new CDbCriteria();
        foreach ($attributes as $attribute => $value)
        {
            $criteria->compare($attribute, $value);
        }

        return $this->exists($criteria);
    }


    public function getErrorsFlatArray()
    {
        $result = array();

        foreach ((array)$this->errors as $attribute => $errors)
        {
            foreach ($errors as $error)
            {
                $result[] = array(
                    'attribute' => $attribute,
                    'label'     => $this->getAttributeLabel($attribute),
                    'error'     => $error
                );
            }
        }

        return $result;
    }


    public function getUrl()
    {
        return $this->getActionUrl("view", array('id' => $this->id));
    }


    public function getUpdateUrl()
    {

        return $this->getActionUrl("update", array('id' => $this->id));
    }


    public function getCreateUrl()
    {

        return $this->getActionUrl("create");
    }


    public function getDeleteUrl()
    {

        return $this->getActionUrl("delete");
    }


    public function getActionUrl($action, $params = array())
    {
        $model  = lcfirst(get_class($this));
        $module = AppManager::getModelModule($model);

        return Yii::app()->createUrl("/$module/$model/$action", $params);
    }


    public function throw404IfNull()
    {
        /*
        if not clone than expression:
        User::model()->throw404IfNull()->findByPk(Yii::app()->user->model->id);
        will not working right, because User::model() is reference on object from AR::model cache and
        Yii::app()->user->model will do User::model() for finding record already with our flag
        */
        $clone = clone $this;
        $clone->_throw404IfNull = true;
        return $clone;
    }

    public function asArray()
    {
        $clone = clone $this; // please see comments for self::throw404IfNull() about it
        $clone->_asArray = true;
        return $clone;
    }

    /*___________________________________________________________________________________*/


    /*find* methods______________________________________________________________________*/

    /**
     * @param mixed  $pk
     * @param string $condition
     * @param array  $params
     * @return self
     */
    public function findByPk($pk,$condition='',$params=array())
    {
        $method = $this->_asArray ? 'findByPkRaw' : 'findByPk';
        $result = parent::$method($pk, $condition, $params);

        if ($this->_throw404IfNull && $result === null)
        {
            Yii::app()->controller->pageNotFound();
        }
        return $result;
    }

    /**
     * @param array  $attributes
     * @param string $condition
     * @param array  $params
     * @return self
     */
    public function findByAttributes($attributes,$condition='',$params=array())
    {
        $method = $this->_asArray ? 'findByAttributesRaw' : 'findByAttributes';
        $result = parent::$method($attributes, $condition, $params);

        if ($this->_throw404IfNull && $result === null)
        {
            Yii::app()->controller->pageNotFound();
        }
        return $result;
    }

    /**
     * @param string $condition
     * @param array  $params
     * @return self[]
     */
    public function find($condition='',$params=array())
    {
        $method = $this->_asArray ? 'findRaw' : 'find';
        return parent::$method($condition, $params);
    }

    /**
     * @param string $condition
     * @param array  $params
     * @return self[]
     */
    public function findAll($condition='',$params=array())
    {
        $method = $this->_asArray ? 'findAllRaw' : 'findAll';
        return parent::$method($condition, $params);
    }

    /**
     * @param mixed  $pk
     * @param string $condition
     * @param array  $params
     * @return self[]
     */
    public function findAllByPk($pk,$condition='',$params=array())
    {
        $method = $this->_asArray ? 'findAllByPkRaw' : 'findAllByPk';
        return parent::$method($pk, $condition, $params);
    }

    /**
     * @param array  $attributes
     * @param string $condition
     * @param array  $params
     * @return self[]
     */
    public function findAllByAttributes($attributes,$condition='',$params=array())
    {
        $method = $this->_asArray ? 'findAllByAttributesRaw' : 'findAllByAttributes';
        return parent::$method($attributes, $condition, $params);
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->_asArray = $this->_throw404IfNull = false;
    }


}
