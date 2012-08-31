<?

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
		return array();
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
        $sql = "SELECT GROUP_CONCAT(tags.name SEPARATOR  ', ') AS tags_string
                       FROM " . Tag::tableName() . " tags
                       INNER JOIN " . TagRel::tableName() . " tags_rels
                           ON tags_rels.tag_id     = tags.id       AND
                               tags_rels.object_id = {$object_id} AND
                               model_id            = '{$model_id}'";

       return Yii::app()->db->createCommand($sql)->queryScalar();
    }

}