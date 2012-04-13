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
			array('tag', 'required'),
			array('tag', 'unique'),
		);
	}


	public function relations()
	{
		return array();
	}


    public function search()
   	{
   		$criteria = new CDbCriteria;
   		$criteria->compare('tag', $this->object_id, true);

   		return new ActiveDataProvider(get_class($this), array(
   			'criteria' => $criteria
   		));
   	}
}