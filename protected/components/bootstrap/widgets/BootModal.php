<?php
/**
 * BootModal class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @since 0.9.3
 */

Yii::import('bootstrap.widgets.BootWidget');

// todo: update to work with Bootstrap 2.
class BootModal extends BootWidget
{
	/**
	 * @var string the name of the container element. Defaults to 'div'.
	 */
	public $tagName = 'div';

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		parent::init();
		$this->registerScriptFile('jquery.ui.boot-modal.js');

		$id = $this->getId();
		if (isset($this->htmlOptions['id']))
			$id = $this->htmlOptions['id'];
		else
			$this->htmlOptions['id'] = $id;

		$options = !empty($this->options) ? CJavaScript::encode($this->options) : '';
        $this->registerScript(__CLASS__.'#'.$id, "jQuery('#{$id}').bootModal($options);");

		echo CHtml::openTag($this->tagName, $this->htmlOptions).PHP_EOL;
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		echo CHtml::closeTag($this->tagName);
	}
}
