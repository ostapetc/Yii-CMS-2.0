<?php
/** 
 * 
 * !Attributes - атрибуты БД
 * @property integer $id
 * @property string  $level
 * @property string  $category
 * @property string  $logtime
 * @property string  $message
 * 
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property         $errorsFlatArray
 * @property         $url
 * @property         $updateUrl
 * @property         $createUrl
 * @property         $deleteUrl
 * 
 * !Scopes - именованные группы условий, возвращают этот АР
 * @method   Log     published()
 * @method   Log     sitemap()
 * @method   Log     ordered()
 * @method   Log     last()
 * 
 */

class Log extends ActiveRecord
{
    const PAGE_SIZE = 10;


    public function name()
    {
        return 'Логи';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'log';
	}


	public function rules()
	{
		return array(
			array('level, category', 'length', 'max'=>128),
			array('message', 'safe'),
			array('id, level, category, logtime, message', 'safe', 'on'=>'search'),
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
		$criteria->compare('id',$this->id);
		$criteria->compare('level',$this->level,true);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('logtime',$this->logtime);
		$criteria->compare('message',$this->message,true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'logtime DESC'
            )
		));
	}
}