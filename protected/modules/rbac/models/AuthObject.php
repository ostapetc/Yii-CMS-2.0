<?php

class AuthObject extends ActiveRecordModel
{
    const PAGE_SIZE = 10;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'auth_objects';
	}


    public function name()
    {
        return 'Доступ к объектам';
    }


	public function rules()
	{
		return array(
			array('object_id, model_id', 'required'),
			array('object_id', 'length', 'max' => 11),
			array('model_id', 'length', 'max' => 50),

			array('id, object_id, model_id', 'safe', 'on' => 'search'),
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
		$criteria->compare('object_id', $this->object_id, true);
		$criteria->compare('model_id', $this->model_id, true);

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria
		));
	}


    public function getObjectsIds($model_id, $role)
    {
        $object_ids = array();

        $sql = "SELECT object_id
                       FROM " . $this->tableName() . "
                       WHERE model_id = '{$model_id}' AND
                             role     = '{$role}'";

        $result = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($result as $data)
        {
            $object_ids[] = $data['object_id'];
        }
      
        return $object_ids;
    }


    public function getRolesNames($model_id, $object_id)
    {
        $roles_names = array();

        if (!$object_id)
        {
            return $roles_names;
        }

        $sql = "SELECT role
                       FROM " . $this->tableName() . "
                       WHERE model_id  = '{$model_id}' AND
                             object_id = '{$object_id}'";

        $result = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($result as $data)
        {
            $roles_names[] = $data['role'];
        }

        return $roles_names;
    }
}