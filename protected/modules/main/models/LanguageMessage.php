<?php
class LanguageMessage extends ActiveRecordModel
{
    const PAGE_SIZE = 10;

    const DEFAULT_CATEGORY = 'main';

    public $translations;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'languages_messages';
	}


    public function name()
    {
        return 'Модель LanguageMessage';
    }


	public function rules()
	{
		return array(
            array('message', 'required'),
			array('category', 'length', 'max' => 32),
			array('message', 'safe'),
            array('message', 'unique'),
			array('id, category, message', 'safe', 'on' => 'search'),
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('category', $this->category, true);
		$criteria->compare('message', $this->message, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public static function getCachedArray()
    {
        $messages = Yii::app()->cache->get('languages_messages');
        if (!$messages)
        {
            $sql = "SELECT message FROM " . self::tableName();
            $res = Yii::app()->db->createCommand($sql)->queryAll();

            $messages = ArrayHelper::extract($res, 'message');
            Yii::app()->cache->set('languages_messages', $messages);
        }

        return $messages;
    }


    public function translation($language_id)
    {
        $sql = "SELECT translation
                       FROM " . LanguageTranslation::tableName() . "
                       WHERE language = '{$language_id}' AND
                             id = {$this->id}";

        return Yii::app()->db->createCommand($sql)->queryScalar();
    }


    public function afterSave()
    {
        LanguageTranslation::model()->deleteAll('id = ' . $this->id);

        if ($this->translations)
        {
            foreach ($this->translations as $language => $translation)
            {
                $language_translation = new LanguageTranslation();
                $language_translation->id          = $this->id;
                $language_translation->translation = $translation;
                $language_translation->language    = $language;
                $language_translation->save();
            }
        }
    }
}