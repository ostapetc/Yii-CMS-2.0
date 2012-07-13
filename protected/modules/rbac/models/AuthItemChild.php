<?

class AuthItemChild extends ActiveRecord
{
    public function name()
    {
        return 'Дети элементов авторизации';
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'auth_items_childs';
	}


	public function rules()
	{
		return array(
			array('parent, child', 'required'),
			array('parent, child', 'length', 'max' => 64),
			array('parent, child', 'safe', 'on' => 'search'),
		);
	}
}