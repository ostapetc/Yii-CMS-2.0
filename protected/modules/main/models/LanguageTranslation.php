<?php
/** 
 * @property                   $id
 * @property                   $language
 * @property                   $translation
 * @property                   $newAttachedModel
 * @property mixed             $related          the related object(s).
 * @property string            $attributeLabel   the attribute label
 * @property CActiveRelation   $activeRelation   the named relation declared for this AR class. Null if the relation does not exist.
 * @property mixed             $attribute        the attribute value. Null if the attribute is not set or does not exist.
 * @property string            $error            the error message. Null is returned if no error.
 * @property CList             $eventHandlers    list of attached event handlers for the event
 * @property LanguagesMessages $id0
 * 
 */

class LanguageTranslation extends ActiveRecord
{
    const PAGE_SIZE = 10;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'languages_translations';
	}


    public function name()
    {
        return 'Модель LanguageTranslation';
    }


	public function rules()
	{
		return array(
			array('id', 'required'),
			array('id', 'numerical', 'integerOnly' => true),
			array('language', 'length', 'max' => 16),
			array('translation', 'safe'),

			array('id, language, translation', 'safe', 'on' => 'search'),
		);
	}


	public function relations()
	{
		return array(
			'id0' => array(self::BELONGS_TO, 'LanguagesMessages', 'id'),
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('language', $this->language, true);
		$criteria->compare('translation', $this->translation, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}
}