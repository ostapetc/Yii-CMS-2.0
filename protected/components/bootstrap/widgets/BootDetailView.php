<?php
/**
 * BootDetailView class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('zii.widgets.CDetailView');

class BootDetailView extends CDetailView
{
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
