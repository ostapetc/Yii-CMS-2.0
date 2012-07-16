<?php

/**
 * Yii extension wrapping the jQuery UI MultiSelect Widget from Eric Hynds
 * {@link http://www.erichynds.com/jquery/jquery-ui-multiselect-widget/}
 * 
 * @author C.Yildiz <c@cba-solutions.org>
 *
 */
Yii::import('zii.widgets.jui.CJuiInputWidget');

/**
 * Base class.
 */
class EchMultiselect extends CJuiInputWidget
{
	 /**
	 * @var CModel the data model associated with this widget.
	 */
	public $model;
	/**
	 * @var string the attribute associated with this widget.
	 * The name can contain square brackets (e.g. 'name[1]') which is used to collect tabular data input.
	 */
	public $dropDownAttribute;
	/**
	 * @var string the name of the drop down list. This must be set if {@link model} is not set.
	 */
	public $name = '';
	/**
	 * @var string the selected input value(s). This is used only if {@link model} is not set.
	 */
	public $value = array();
	/**
	 * @var array data for generating the options of the drop down list
	 */
	public $data = array();
	/**
	 * @var array the options for the jQuery UI MultiSelect Widget
	 */
	public $options = array();
	/**
    * @var array the options for the jQuery UI MultiSelect Filter Widget
    */
    public $filterOptions = array();
	/**
	 * @var array additional HTML attributes for the drop down list
	 * Options like class, style etc. are adopted by the jQuery UI MultiSelect Widget
	 */
	public $dropDownHtmlOptions = array();
	



	public function init()
	{
		// Put togehther options for plugin
		$options_default = array(
			'checkAllText' => Yii::t('application','Check all'),
			'uncheckAllText' => Yii::t('application','Uncheck all'),
			'selectedText' =>Yii::t('application','# selected'),
			'noneSelectedText'=>'-- ' . Yii::t('application','Select Options') . ' --',
			'multiple'=>true,
			'filter'=>false,
		);
		$filterOptions_default = array(
			'label' => Yii::t('application','Filter:'),
			'placeholder'=>Yii::t('application','Enter keywords'),
		);
		$opt = array_merge($options_default, $this->options);
		$fopt = array_merge($filterOptions_default, $this->filterOptions);
		if($opt['multiple'] === false && !isset($this->options['noneSelectedText'])) 
			$opt['noneSelectedText'] =  '-- ' . Yii::t('application','Select an Option') . ' --';
		$this->options = $opt;
		$this->filterOptions = $fopt;
		
		// make sure multiple="multiple" is set for drop down list
		if($this->options['multiple']) $this->dropDownHtmlOptions['multiple'] = true;
		
		$cs = Yii::app()->getClientScript();
		$assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . '/assets');
		$cs->registerScriptFile($assets . '/jquery.ui.widget.min.js');
		$cs->registerScriptFile($assets . '/jquery.multiselect.js');
		$cs->registerCssFile($assets . '/jquery.multiselect.css');
		if($this->options['filter'] === true) {
			$cs->registerScriptFile($assets . '/jquery.multiselect.filter.js');
			$cs->registerCssFile($assets . '/jquery.multiselect.filter.css');
		}

		parent::init();
	}

	/**
	 * Run this widget.
	 * This method registers necessary javascript and renders the needed HTML code.
	 */
	public function run()
	{
		list($name, $id) = $this->resolveDropDownNameID();
		// Render drop-down element and hide it with javascript
		if ($this->hasModel())
			echo CHtml::activeDropDownList($this->model, $this->dropDownAttribute, $this->data, $this->dropDownHtmlOptions);
		else
			echo CHtml::dropDownList($name, $this->value, $this->data, $this->dropDownHtmlOptions);		
		// Put the script to hide the select-element directly after the element itself, so it is hidden directly after it is rendered
		// Resource: http://www.electrictoolbox.com/jquery-hide-text-page-load-show-later/
		echo '<script type="text/javascript">
				$("#'.$id.'").hide();
			</script>';
			
		$joptions=CJavaScript::encode($this->options);
        $jfilterOptions=CJavaScript::encode($this->filterOptions);
		if($this->options['filter'] === true) {
            $jscode = "jQuery('#{$id}').multiselect({$joptions}).multiselectfilter({$jfilterOptions});";
			unset($this->options['filter']);
		}
		else 
			$jscode = "jQuery('#{$id}').multiselect({$joptions});";
		Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $id, $jscode);
	}
	
	
	
	/**
	 * @return array the name and the ID of the drop-down element.
	 */
	protected function resolveDropDownNameID()
	{
		$ni = array();
		if(!empty($this->name))
			$dname=$this->name;
		else if($this->hasModel()) {
			$dname=CHtml::activeName($this->model,$this->dropDownAttribute);
			CHtml::resolveNameID($this->model, $this->dropDownAttribute, $ni);
		}
		else
			throw new CException(Yii::t('application','{class} must specify "model" and "dropDownAttribute" or "name" property values.',array('{class}'=>get_class($this))));

		if(isset($this->dropDownHtmlOptions['id']))
			$id=$this->dropDownHtmlOptions['id'];
		else if(!empty($ni['id']))
			$id=$ni['id'];
		else 
			$id=CHtml::getIdByName($dname);

		return array($dname,$id);
	}
	
	/**
	 * @return boolean whether this widget is associated with a data model.
	 */
	protected function hasModel()
	{
		return ($this->model instanceof CModel) && !empty($this->dropDownAttribute);
	}
}
