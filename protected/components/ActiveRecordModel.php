<?php

abstract class ActiveRecordModel extends CActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';


    abstract public function name();


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function behaviors()
    {
        return array(
            'LangCondition'  => array(
                'class' => 'application.components.activeRecordBehaviors.LangConditionBehavior'
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
        );
    }


    public function attributeLabels()
    {
        $meta = $this->meta();

        $labels = array();

        foreach ($meta as $field_data)
        {
            $labels[$field_data["Field"]] = Yii::t('main', $field_data["Comment"]);
        }

        return $labels;
    }


    public function __get($name)
    {
        try
        {
            return parent::__get($name);
        } catch (CException $e)
        {
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
        } catch (CException $e)
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
            'ordered'   => array('order' => $alias . '.`order`'),
            'last'      => array('order' => $alias . '.date_create DESC')
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


    public function in($row, $values, $operator = 'AND')
    {
        $this->getDbCriteria()->addInCondition($row, $values, $operator);
        return $this->owner;
    }


    public function notIn($row, $values, $operator = 'AND')
    {
        $this->getDbCriteria()->addNotInCondition($row, $values, $operator);
        return $this->owner;
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
        $cache_var = 'Meta_' . $this->tableName();

        $meta = Yii::app()->cache->get($cache_var);
        if ($meta === false)
        {
            $meta = Yii::app()->db->createCommand("SHOW FUll columns FROM " . $this->tableName())->queryAll();

            foreach ($meta as $ind => $field_data)
            {
                $meta[$field_data["Field"]] = $field_data;
                unset($meta[$ind]);
            }

            Yii::app()->cache->set($cache_var, $meta, 3600);
        }

        return $meta;
    }


    public function optionsTree($name = 'name', $id = null, $result = array(), $value = 'id', $spaces = 0, $parent_id = null)
    {
        $objects = $this->findAllByAttributes(array(
            'parent_id' => $parent_id
        ));

        foreach ($objects as $object)
        {
            if ($object->id == $id)
            {
                continue;
            }

            $result[$object->$value] = str_repeat("_", $spaces) . $object->$name;

            if ($object->childs)
            {
                $spaces += 2;

                $result = $this->optionsTree($name, $id, $result, $value, $spaces, $object->id);
            }
        }

        return $result;
    }


    public function authObject()
    {
        $object_ids = AuthObject::model()->getObjectsIds(get_class($this), Yii::app()->user->role);

        $criteria = $this->getDbCriteria();
        $criteria->addInCondition('id', $object_ids);
        return $this;
    }
}
