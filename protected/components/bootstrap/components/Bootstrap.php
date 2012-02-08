<?php
/**
 * Bootstrap class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

class Bootstrap extends CApplicationComponent
{
	/**
	 * @var string the assets url for this extension.
	 */
	protected $_assetsUrl;

	/**
	 * Initializes the component.
	 */
	public function init()
	{
		if (!Yii::getPathOfAlias('bootstrap'))
			Yii::setPathOfAlias('bootstrap', realpath(dirname(__FILE__).'/..'));
        Yii::import('bootstrap.widgets.*');
	}

	/**
	 * Registers the Bootstrap CSS.
	 */
	public function registerCss()
	{
		Yii::app()->clientScript->registerCssFile($this->getAssetsUrl().'/css/bootstrap.min.css');
	}

	/**
	 * Registers the Bootstrap responsive CSS.
	 * @since 0.9.8
	 */
	public function registerResponsiveCss()
	{
		Yii::app()->clientScript->registerCssFile($this->getAssetsUrl().'/css/bootstrap-responsive.min.css');
	}

	/**
	 * Registers the Bootstrap core JavaScript functionality.
	 * @since 0.9.8
	 */
	public function registerCoreScript()
	{
		$this->registerScriptFile('jquery.ui.boot-dropdown.js');

		Yii::app()->clientScript->registerScript(__CLASS__, "jQuery('.dropdown-toggle[data-toggle=\"dropdown\"]').bootDropdown();");
	}

	/**
	 * Registers a Bootstrap JavaScript file.
	 * @param string $fileName the file name.
     * @param integer $position the position of the JavaScript file.
	 */
	public function registerScriptFile($fileName, $position=CClientScript::POS_HEAD)
	{
		Yii::app()->clientScript->registerScriptFile($this->getAssetsUrl().'/js/'.$fileName, $position);
	}

	/**
	* Returns the url to assets publishing the folder if necessary.
	* @return string the assets url
	*/
	protected function getAssetsUrl()
	{
		if ($this->_assetsUrl !== null)
			return $this->_assetsUrl;
		else
		{
			$assetsPath = Yii::getPathOfAlias('bootstrap.assets');

			if (YII_DEBUG)
				$assetsUrl = Yii::app()->assetManager->publish($assetsPath, false, -1, true);
			else
				$assetsUrl = Yii::app()->assetManager->publish($assetsPath);

			return $this->_assetsUrl = $assetsUrl;
		}
	}
}
