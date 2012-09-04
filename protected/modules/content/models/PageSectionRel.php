<?php
/** 
 * @property                 $id
 * @property                 $page_id
 * @property                 $section_id
 * @property                 $href
 * @property                 $sectionsIds
 * @property                 $newAttachedModel
 * @property mixed           $related          the related object(s).
 * @property string          $attributeLabel   the attribute label
 * @property CActiveRelation $activeRelation   the named relation declared for this AR class. Null if the relation does not exist.
 * @property mixed           $attribute        the attribute value. Null if the attribute is not set or does not exist.
 * @property string          $error            the error message. Null is returned if no error.
 * @property CList           $eventHandlers    list of attached event handlers for the event
 * 
 */

class PageSectionRel extends ActiveRecord
{
    const PAGE_SIZE = 20;



    public function name()
    {
        return 'PageSectionRel';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'pages_sections_rels';
    }


    public function rules()
    {
        return array(
            array(
                'page_id, section_id',
                'required'
            ),

            array(
                '',
                'unique'
            ),
        );
    }


    public function relations()
    {
        return array(
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('page_id', $this->page_id, true);
        $criteria->compare('section_id', $this->section_id, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function getHref()
    {
        return Yii::app()->createUrl('/content/pagesectionrel/view', array('id' => $this->id));
    }


    public function uploadFiles()
    {
        return array(
        );
    }


    public function getSectionsIds($page_id)
    {
        $sql = "SELECT section_id
                       FROM
                       " . $this->tableName() . "
                       WHERE page_id = {$page_id}";

        $sections_ids = Yii::app()->db->createCommand($sql)->queryAll();
        return ArrayHelper::extract($sections_ids, 'section_id');
    }
}
