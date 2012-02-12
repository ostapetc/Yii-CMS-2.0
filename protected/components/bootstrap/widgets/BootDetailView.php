<?php
/**
 * BootDetailView class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

Yii::import('zii.widgets.CDetailView');

/**
 * Bootstrap detail view widget.
 * Used for setting default HTML classes and disabling the default CSS.
 */
class BootDetailView extends CDetailView
{
	/**
	 * @var string the template used to render a single attribute. Defaults to a table row.
	 */
	public $itemTemplate="<tr class=\"{class}\"><th style=\"width: 160px\">{label}</th><td>{value}</td></tr>\n";
	/**
	 * @var array the CSS class names for the items displaying attribute values.
	 */
	public $itemCssClass = array();
	/**
	 * @var array the HTML attributes for the container.
	 */
	public $htmlOptions = array('class'=>'table table-striped table-condensed detail-view');
	/**
	 * @var string the URL of the CSS file used by this detail view.
	 * Defaults to false, meaning that no CSS will be included.
	 */
	public $cssFile = false;
}
