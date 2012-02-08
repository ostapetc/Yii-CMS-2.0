<?php
/**
 * BootAlert class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright  Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('bootstrap.widgets.BootWidget');

class BootAlert extends BootWidget
{
	/**
	 * @var array the keys for which to get flash messages.
	 */
	public $keys = array('success', 'info', 'warning', 'error', /* or */'danger');
	/**
	 * @var string the template to use for displaying flash messages.
	 */
	public $template = '<div class="alert alert-block alert-{key}"><a class="close">&times;</a>{message}</div>';
	/**
	 * @var array the html options.
	 */
	public $htmlOptions = array();

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		parent::init();
		$this->registerScriptFile('jquery.ui.boot-alert.js');
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		$id = $this->getId();

		if (isset($this->htmlOptions['id']))
			$id = $this->htmlOptions['id'];
		else
			$this->htmlOptions['id'] = $id;

		if (is_string($this->keys))
			$this->keys = array($this->keys);

		echo CHtml::openTag('div',$this->htmlOptions);

		foreach ($this->keys as $key)
			if (Yii::app()->user->hasFlash($key))
				echo strtr($this->template, array('{key}'=>$key, '{message}'=>Yii::app()->user->getFlash($key)));

		echo '</div>';

		$this->options['keys'] = $this->keys;
		$this->options['template'] = $this->template;

		$options = !empty($this->options) ? CJavaScript::encode($this->options) : '';
		Yii::app()->clientScript->registerScript(__CLASS__.'#'.$id,"jQuery('#{$id}').bootAlert({$options});");
	}
}
