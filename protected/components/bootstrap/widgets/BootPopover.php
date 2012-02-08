<?php
/**
 * BootPopover class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('bootstrap.widgets.BootTooltip');

/**
 * Bootstrap rich-content tooltip widget.
 * @since 0.9.2
 */
class BootPopover extends BootTooltip
{
	/**
	 * @var string the CSS selector to use for selecting the pop-over elements.
	 */
	public $selector = 'a[rel="popover"]';
	
	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		parent::init();
		$this->registerScriptFile('jquery.ui.boot-popover.js');
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		$id = $this->getId();
		$options = !empty($this->options) ? CJavaScript::encode($this->options) : '';
        $this->registerScript(__CLASS__.'#'.$id,"jQuery('{$this->selector}').bootPopover($options);");
	}
}
