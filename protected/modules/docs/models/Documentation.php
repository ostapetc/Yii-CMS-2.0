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
                'title, content', 'required'
            ), array(
                'is_published', 'numerical',
                'integerOnly' => true
            ), array(
                'id', 'length',
                'max' => 11
            ), array(
                'title', 'length',
                'max' => 250
            ), array(
                'title, alias', 'unique'
            ), array(
                'alias', 'AliasValidator'
            ), array(
                'id, title, is_published', 'safe',
                'on' => 'search'
            ),
        );
    }


    public function relations()
    {
        return array(
            'category' => array(
                self::BELONGS_TO, 'DocumentationCategory', 'cat_id',
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
