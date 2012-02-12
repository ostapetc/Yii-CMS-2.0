<?php
/**
 * BootGridView class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

Yii::import('zii.widgets.grid.CGridView');

/**
 * Bootstrap grid view widget.
 * Used for setting default HTML classes, disabling the default CSS and enable the bootstrap pager.
 */
class BootGridView extends CGridView
{
	/**
	 * @var string the CSS class name for the container table. Defaults to 'table'.
	 */
	public $itemsCssClass = 'table table-striped';
	/**
	 * @var string the CSS class name for the pager container.
	 * Defaults to 'pagination'.
	 */
	public $pagerCssClass = 'pagination';
	/**
	 * @var array the configuration for the pager.
	 * Defaults to <code>array('class'=>'ext.bootstrap.widgets.BootPager')</code>.
	 */
	public $pager = array('class'=>'bootstrap.widgets.BootPager');
	/**
	 * @var string the URL of the CSS file used by this detail view.
	 * Defaults to false, meaning that no CSS will be included.
	 */
	public $cssFile = false;
}
