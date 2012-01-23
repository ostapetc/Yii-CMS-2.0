<?php 
/**
 * ApListView class file.
 * 
 * Extension of CListView to make it useable with
 * AlphaPagination.
 * 
 * @author Jascha Koch
 * @license MIT License - http://www.opensource.org/licenses/mit-license.html
 * @version 1.0
 * @package alphapager
 * @since 1.3
 */

Yii::import('zii.widgets.CListView');

class ApListView extends ListView
{
    public $template="{alphapager}\n{items}\n{pager}";

    public $ajaxUpdate = false;
	/**
	 * @var boolean whether to enable alphapagination. Note that if the {@link IDataProvider::alphapagination} property
	 * of {@link dataProvider} is false, this will be treated as false as well. When alphanumerical pagination is enabled,
	 * a pager will be displayed in the view so that it can trigger alphanumerical pagination of the data display.
	 * Defaults to true.
	 */
	public $enableAlphaPagination=true;
	/**
	 * @var array the configuration for the alphapager. Defaults to <code>array('class'=>'ApLinkPager')</code>.
	 * @see enableAlphaPagination
	 */
	public $alphaPager=array('class'=>'ApLinkPager');
	/**
	 * @var string the CSS class name for the alphapager container. Defaults to 'alphapager'.
	 */
	public $alphaPagerCssClass='alphaPager';
	
	/**
	 * Initializes the view.
	 */
	public function init()
	{
		if($this->enablePagination===false)
			$this->dataProvider->setPagination(false);
		
		if($this->enableAlphaPagination && $this->dataProvider->getAlphaPagination()===false)
			$this->enableAlphaPagination=false;
		
		parent::init();
	}
	
	/**
	 * Renders the alphapager.
	 */
	public function renderAlphapager()
	{
		if(!$this->enableAlphaPagination)
			return;
		
		$pager=array();
		$class='ApLinkPager';

		if(is_string($this->alphaPager))
			$class=$this->alphaPager;
		else if(is_array($this->alphaPager))
		{
			$pager=$this->alphaPager;
			if(isset($pager['class']))
			{
				$class=$pager['class'];
				unset($pager['class']);
			}
		}

		// Register javascript snippet for ajax updating
		if($this->ajaxUpdate!==false)
		{
			$id = $this->getId();
			$cs=Yii::app()->getClientScript();
			if($class == 'ApLinkPager')
			{
				$cs->registerScript(__CLASS__.'#'.$id,"jQuery('#".$id." .".$this->alphaPagerCssClass." a').live('click',function(){ $.fn.yiiListView.update('".$id."',{url: $(this).attr('href')});return false; });");
			}
			else if($class == 'ApListPager')
			{
				$cs->registerScript(__CLASS__.'#'.$id,"jQuery('#".$id." .".$this->alphaPagerCssClass." select').live('change',function(){ $.fn.yiiListView.update('".$id."',{url: $(this).val()});return false; });");
				// Dont add the onchange event to list pager when ajax update should be used 
				$pager['htmlOptions']['onchange'] = false;
			}
		}
			
		$pager['pages']=$this->dataProvider->getAlphaPagination();
		echo '<div class="'.$this->alphaPagerCssClass.'">';
		$this->widget($class,$pager);
		echo '</div>';
	}
}