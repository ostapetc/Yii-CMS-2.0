<?php

class Documentation extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


    public function name()
    {
        return 'Документация';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'Documentation';
    }


    public function rules()
    {
        return array(
            array(
                'title', 'content',
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
                'title',
                'length',
                'max' => 250
            ),
            array(
                'name',
                'unique',
            ),
            array(
                'id, title, is_visible',
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
            'category' => array(
                self::BELONGS_TO,
                'DocumentationCategory',
                'cat_id',
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

}
