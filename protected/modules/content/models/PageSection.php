<?php
/** 
 * @property                 $href
 * @property                 $info
 * @property                 $languageName
 * @property CComponent      $owner            the owner component that this behavior is attached to.
 * @property boolean         $enabled          whether this behavior is enabled
 * @property PageSection     $parent
 * @property PageSection[]   $childs
 * @method   PageSection     published()
 * @method   PageSection     sitemap()
 * @method   PageSection     ordered()
 * @method   PageSection     last()
 * 
 */

class PageSection extends ActiveRecord
{
    const PAGE_SIZE = 20;



    public function name()
    {
        return 'Раздел страниц';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'pages_sections';
    }


    public function rules()
    {
        return array(
            array(
                'name',
                'required'
            ),
            array(
                'name',
                'length',
                'max' => 50
            ),
            array(
                'name',
                'unique'
            ),
            array(
                'parent_id',
                'numerical',
                'integerOnly' => true
            )
        );
    }


    public function relations()
    {
        return array(
            'parent' => array(
                self::BELONGS_TO,
                'PageSection',
                'parent_id'
            ),
            'childs' => array(
                self::HAS_MANY,
                'PageSection',
                'parent_id'
            )
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('parent_id', $this->parent_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('order', $this->order, true);
        $criteria->compare('date_create', $this->date_create, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function getHref()
    {
        return Yii::app()->createUrl('/content/pagesection/view', array('id' => $this->id));
    }


    public function uploadFiles()
    {
        return array(
        );
    }
}
