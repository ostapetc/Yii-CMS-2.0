<?php
/**
 * BootGridView class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('zii.widgets.grid.CGridView');

class BootGridView extends CGridView
{
	/**
	 * @var boolean whether to display the table even when there is no data. Defaults to false.
	 */
	public $showTableOnEmpty = false;

	/**
	 * @var string the CSS class name for the container table. Defaults to 'table'.
	 */
	public $itemsCssClass = 'table';
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
}
