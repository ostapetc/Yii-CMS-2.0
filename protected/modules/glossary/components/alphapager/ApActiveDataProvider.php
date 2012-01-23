<?php
/**
 * ApActiveDataProvider class file.
 * 
 * Extension of CActiveDataProvider to make it useable with
 * AlphaPagination.
 * Needed to run e.g. ListView or GridView with AlphaPagination. 
 * 
 * @author Jascha Koch
 * @license MIT License - http://www.opensource.org/licenses/mit-license.html
 * @version 1.1
 * @package alphapager
 * @since 1.3
 */


class ApActiveDataProvider extends CActiveDataProvider
{
	private $_alphapagination;
	
	/**
	 * Fetches the data from the persistent data storage.
	 * @return array list of data items
	 */
	protected function fetchData()
	{
		$sourceCriteria=clone $this->getCriteria();
		$criteria=$this->getCriteria();
		if(($alphapagination=$this->getAlphaPagination())!==false)
		{
			$alphapagination->applyCondition($criteria);
		}
		
		$result = parent::fetchData();
		$this->setCriteria($sourceCriteria);

		return $result;
	}
	
	/**
	 * @return AlphaPagination the alphapagination object. If this is false, it means the alphanumerical pagination is disabled.
	 */
	public function getAlphaPagination()
	{
		if($this->_alphapagination===null)
		{
			$this->_alphapagination=new ApPagination;
			$this->_alphapagination->pageVar=$this->getId().'_alphapage';
			$this->setPagination($this->_alphapagination->getPagination());
		}

		return $this->_alphapagination;
	}

	/**
	 * @param mixed the alphapagination to be used by this data provider. This could be a {@link AlphaPagination} object
	 * or an array used to configure the alphapagination object. If this is false, it means the alphanumerical pagination should be disabled.
	 */
	public function setAlphaPagination($value)
	{
		if(is_array($value))
		{
			$pagination=$this->getAlphaPagination();
			foreach($value as $k=>$v)
				$pagination->$k=$v;
		}
		else
			$this->_alphapagination=$value;
	}

}