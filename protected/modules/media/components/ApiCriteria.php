<?php
class ApiCriteria extends CComponent
{
	public $select='';
	public $limit=-1;
	public $offset=-1;
	public $order='';

	/**
	 * Constructor.
	 * @param array $data criteria initial property values (indexed by property name)
	 */
	public function __construct($data=array())
	{
		foreach($data as $name=>$value)
			$this->$name=$value;
	}
}
