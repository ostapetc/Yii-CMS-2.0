<?php

class AuthItemChild extends ActiveRecordModel
{
	const PHOTOS_DIR = 'upload/news';


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


	public function relations()
	{
		return array(
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('parent', $this->parent, true);
		$criteria->compare('child', $this->child, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    /*
     * TODO: replace queryALL
     */
    public function getAllowedTasks($role)
    {
        $tasks = array();

        $sql = "SELECT child
                       FROM " . self::tableName() . "
                       WHERE parent = '{$role}'";

        $result = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($result as $data)
        {
            $tasks[] = $data['child'];
        }

        return $tasks;
    }
}