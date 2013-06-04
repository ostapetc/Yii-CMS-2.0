<?
/** 
 * 
 * !Attributes - атрибуты БД
 * @property string $id
 * @property string $name
 * 
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property        $errorsFlatArray
 * @property        $url
 * @property        $updateUrl
 * @property        $createUrl
 * @property        $deleteUrl
 * 
 * !Scopes - именованные группы условий, возвращают этот АР
 * @method   Tag    ordered()
 * @method   Tag    last()
 * 
 */

class Tag extends ActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'tags';
	}


    public function name()
    {
        return 'Теги';
    }


	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name', 'unique'),
            array('name', 'filter', 'filter' => 'strip_tags'),
		);
	}


	public function relations()
	{
		return array(
            'rels_count' => [
                self::STAT,
                'TagRel',
                'tag_id'
            ]
        );
	}


    public function search()
   	{
   		$criteria = new CDbCriteria;
   		$criteria->compare('name', $this->object_id, true);

   		return new ActiveDataProvider(get_class($this), array(
   			'criteria' => $criteria
   		));
   	}


    public static function getString($model_id, $object_id)
    {
        $model = ActiveRecord::model($model_id)->findByPk($object_id);
        if ($model)
        {
            $result = CHtml::listData($model->tags, 'id', 'name');
            return implode(', ', $result);
        }
        return '';
    }

}