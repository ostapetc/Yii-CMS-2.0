<?php

class Menu extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


    public function name()
    {
        return 'Меню';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'menu';
    }


    public function rules()
    {
        return array(
            array(
                'name',
                'required'
            ),
            array(
                'is_visible',
                'numerical',
                'integerOnly' => true
            ),
            array(
                'id',
                'length',
                'max' => 11
            ),
            array(
                'name',
                'length',
                'max' => 50
            ),
            array(
                'name',
                'unique',
                'className'     => 'Menu',
                'attributeName' => 'name'
            ),
            array(
                'id, name, is_visible',
                'safe',
                'on' => 'search'
            ),
        );
    }


    public function scopes()
    {
        $alias = $this->getTableAlias();
        return array(
            'visible' => array('condition' => $alias.'.is_visible = 1')
        );
    }

    public function relations()
    {
        return array(
            'links' => array(
                self::HAS_MANY,
                'MenuLink',
                'menu_id',
                'condition' => "lang = '".Yii::app()->language."'"
            ),
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('is_visible', $this->is_visible);

        return new ActiveDataProvider(get_class($this), array(
            'criteria' => $criteria
        ));
    }


    public function getSections()
    {
        $sections = array();

        $role     = Yii::app()->user->role;

        foreach ($this->visible()->links as $link)
        {
            if ($link->parent_id)
            {
                continue;
            }

            if ($link->user_role && ($link->user_role != $role))
            {
                continue;
            }
            else if ($link->not_user_role && ($link->not_user_role == $role))
            {
                continue;
            }

            if ($link->page && !$link->page->is_published)
            {
                continue;
            }

            $sections[] = $link;
        }

        return $sections;
    }
}
