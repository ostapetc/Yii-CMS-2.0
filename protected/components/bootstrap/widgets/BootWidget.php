<?php
/**
 * BootWidget class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

class BootWidget extends CWidget
{
	/**
	 * @var array the initial JavaScript options that should be passed to the Bootstrap plugin.
	 */
	public $options = array();
	/**
	 * @var array the HTML attributes for the widget container.
	 */
	public $htmlOptions = array();

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		Yii::app()->clientScript->registerCoreScript('jquery');
		Yii::app()->clientScript->registerCoreScript('jquery.ui');
		
		$this->registerScriptFile('jquery.ui.boot-widget.js');
	}

	/**
	 * Registers a JavaScript file under Bootstrap.
	 * @param string $fileName the name of the JavaScript file
	 * @param integer $position the position of the JavaScript file
	 */
	protected function registerScriptFile($fileName, $position=CClientScript::POS_HEAD)
	{
		Yii::app()->bootstrap->registerScriptFile($fileName, $position);
	}

    /**
     * Registers a piece of javascript code.
     * @param string $id ID that uniquely identifies this piece of JavaScript code
     * @param string $script the javascript code
     * @param integer $position the position of the JavaScript code
     */
    protected function registerScript($id, $script, $position=CClientScript::POS_END)
    {
        Yii::app()->clientScript->registerScript($id, $script, $position);
    }
}
