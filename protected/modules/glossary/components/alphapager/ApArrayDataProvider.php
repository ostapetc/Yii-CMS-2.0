<?php
/**
 * ApArrayDataProvider class file.
 * 
 * Extension of CArrayDataProvider to make it useable with
 * AlphaPagination.
 * Could be used with ListView or GridView with AlphaPagination. 
 * 
 * @author Jascha Koch
 * @license MIT License - http://www.opensource.org/licenses/mit-license.html
 * @version 1.1
 * @package alphapager
 * @since 1.3
 */


class ApArrayDataProvider extends CArrayDataProvider
{
	private $_alphapagination;
	
	/**
	 * Fetches the data from the persistent data storage.
	 * @return array list of data items
	 */
	protected function fetchData()
	{
		if(($alphapagination=$this->getAlphaPagination())!==false)
		{
			if($alphapagination->attribute!='')
			{
				$alphapagination->resetPaginationVar();
				$currentPage = $alphapagination->getCurrentPage();
				$search = $alphapagination->getDbChar($currentPage-1);
				
				if($currentPage>=0)
					$this->alphaFilterData($currentPage===0?0:$search, $alphapagination->attribute, $alphapagination->forceCaseInsensitive);
			}
			else
				throw new CException(Yii::t('ApPagination.alphapager','There is no value set for "attribute". You must set the model attribute the pagination condition should be applied to.'));
		}
		
		return parent::fetchData();
	}
	
	/**
	 * Filters the raw data according to the specified character.
	 * After calling this method, {@link rawData} will be modified.
	 * @param string the charakter to filter by or 0 to filter by numbers
	 * @param string the attribute that should be filtered
	 * @param bool force case insensitive filtering. Defaults to FALSE meaning case-sensitive     
	 */
	protected function alphaFilterData($search, $attr, $case=false)
	{
		if($search===null || empty($attr))
			return;
		if($case && $search!==0)
			$search = strtolower($search);
			
		foreach($this->rawData as $index=>$data)
		{
			$val = is_object($data) ? $data->{$attr} : $data[$attr];
			if($search===0)
			{
				if(!is_numeric($val[0]))
					unset($this->rawData[$index]);
			}
			else {
				if(($case?strtolower($val[0]):$val[0]) != $search)
					unset($this->rawData[$index]);
			}
		}	
		
		// If pagination isn't used the array needs to be reordered
		if($this->getPagination()===false) 
			$this->rawData=array_values($this->rawData);	
			
		// Refresh total item count
		$this->getTotalItemCount(true);
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