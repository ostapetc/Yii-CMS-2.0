<?php
/**
 * Bootstrap class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

/**
 * Bootstrap application component.
 * Used for registering Bootstrap core functionality.
 */
class Bootstrap extends CApplicationComponent
{
	// The Bootstrap core plugins.
	const PLUGIN_ALERT = 'alert';
	const PLUGIN_BUTTON = 'button';
	const PLUGIN_CAROUSEL = 'carousel';
	const PLUGIN_COLLAPSE = 'collapse';
	const PLUGIN_DROPDOWN = 'dropdown';
	const PLUGIN_MODAL = 'modal';
	const PLUGIN_POPOVER = 'popover';
	const PLUGIN_SCROLLSPY = 'scrollspy';
	const PLUGIN_TAB = 'tab';
	const PLUGIN_TOOLTIP = 'tooltip';
	const PLUGIN_TRANSITION = 'transition';
	const PLUGIN_TYPEAHEAD = 'typeahead';

	/**
	 * @var array the plugin options (name=>options).
	 * @since 0.9.8
	 */
	public $plugins = array();

	protected $_assetsUrl;
	protected $_rp = array();

	/**
	 * Initializes the component.
	 */
	public function init()
	{
		if (!Yii::getPathOfAlias('bootstrap'))
			Yii::setPathOfAlias('bootstrap', realpath(dirname(__FILE__).'/..'));

		Yii::app()->clientScript->registerCoreScript('jquery');
		$this->registerCorePlugins();
	}

	/**
	 * Returns whether a plugin is registered.
	 * @param string $name the name of the plugin
	 * @return boolean the result
	 */
	public function isPluginRegistered($name)
	{
		return isset($this->_rp[$name]);
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
	 * Registers the core JavaScript plugins.
	 * @since 0.9.8
	 */
	protected function registerCorePlugins()
	{
		if (!$this->isPluginDisabled(self::PLUGIN_TRANSITION))
			$this->enableTransitions();

		if (!$this->isPluginDisabled(self::PLUGIN_BUTTON))
			$this->registerButton();

		if (!$this->isPluginDisabled(self::PLUGIN_TOOLTIP))
			$this->registerTooltip();

		if (!$this->isPluginDisabled(self::PLUGIN_POPOVER))
			$this->registerPopover();
	}

	/**
	 * Enables the Bootstrap transitions plugin.
	 * @since 0.9.8
	 */
	public function enableTransitions()
	{
		$this->registerPlugin(self::PLUGIN_TRANSITION);
	}

	/**
	 * Registers the Bootstrap alert plugin.
	 * @param string $selector the CSS selector
	 * @param array $options the plugin options
	 * @see http://twitter.github.com/bootstrap/javascript.html#alerts
	 * @since 0.9.8
	 */
	public function registerAlert($selector = null, $options = array())
	{
		$this->registerPlugin(self::PLUGIN_ALERT, $selector, $options);
	}

	/**
	 * Registers the Bootstrap buttons plugin.
	 * @param string $selector the CSS selector
	 * @param array $options the plugin options
	 * @see http://twitter.github.com/bootstrap/javascript.html#buttons
	 * @since 0.9.8
	 */
	public function registerButton($selector = null, $options = array())
	{
		$this->registerPlugin(self::PLUGIN_BUTTON, $selector, $options);
	}

	/**
	 * Registers the Bootstrap carousel plugin.
	 * @param string $selector the CSS selector
	 * @param array $options the plugin options
	 * @see http://twitter.github.com/bootstrap/javascript.html#carousel
	 * @since 0.9.8
	 */
	public function registerCarousel($selector = null, $options = array())
	{
		$this->registerPlugin(self::PLUGIN_CAROUSEL, $selector, $options);
	}

	/**
	 * Registers the Bootstrap collapse plugin.
	 * @param string $selector the CSS selector
	 * @param array $options the plugin options
	 * @see http://twitter.github.com/bootstrap/javascript.html#collapse
	 * @since 0.9.8
	 */
	public function registerCollapse($selector = null, $options = array())
	{
		$this->registerPlugin(self::PLUGIN_COLLAPSE, $selector, $options, '.collapse');
	}

	/**
	 * Registers the Bootstrap dropdowns plugin.
	 * @param string $selector the CSS selector
	 * @param array $options the plugin options
	 * @see http://twitter.github.com/bootstrap/javascript.html#dropdowns
	 * @since 0.9.8
	 */
	public function registerDropdown($selector = null, $options = array())
	{
		$this->registerPlugin(self::PLUGIN_DROPDOWN, $selector, $options, '.dropdown-toggle[data-dropdown="dropdown"]');
	}

	/**
	 * Registers the Bootstrap modal plugin.
	 * @param string $selector the CSS selector
	 * @param array $options the plugin options
	 * @see http://twitter.github.com/bootstrap/javascript.html#modal
	 * @since 0.9.8
	 */
	public function registerModal($selector = null, $options = array())
	{
		$this->registerPlugin(self::PLUGIN_MODAL, $selector, $options);
	}

	/**
	 * Registers the Bootstrap scrollspy plugin.
	 * @param string $selector the CSS selector
	 * @param array $options the plugin options
	 * @see http://twitter.github.com/bootstrap/javascript.html#scrollspy
	 * @since 0.9.8
	 */
	public function registerScrollSpy($selector = null, $options = array())
	{
		$this->registerPlugin(self::PLUGIN_SCROLLSPY, $selector, $options);

		if (!isset($selector))
		{
			$selector = isset($this->plugins[self::PLUGIN_SCROLLSPY], $this->plugins[self::PLUGIN_SCROLLSPY]['selector'])
					? $this->plugins[self::PLUGIN_SCROLLSPY]['selector']
					: 'body';
		}

		Yii::app()->clientScript->registerScript(__CLASS__.'.scrollspy', "jQuery({$selector}).attr('data-spy', 'scroll');");
	}

	/**
	 * Registers the Bootstrap popover plugin.
	 * @param string $selector the CSS selector
	 * @param array $options the plugin options
	 * @see http://twitter.github.com/bootstrap/javascript.html#popover
	 * @since 0.9.8
	 */
	public function registerPopover($selector = null, $options = array())
	{
		$this->registerTooltip(); // Popover requires the tooltip plugin
		$this->registerPlugin(self::PLUGIN_POPOVER, $selector, $options, 'a[rel="popover"]');
	}

	/**
	 * Registers the Bootstrap tabs plugin.
	 * @param string $selector the CSS selector
	 * @param array $options the plugin options
	 * @see http://twitter.github.com/bootstrap/javascript.html#tabs
	 * @since 0.9.8
	 */
	public function registerTabs($selector = null, $options = array())
	{
		$this->registerPlugin(self::PLUGIN_TAB, $selector, $options);
	}

	/**
	 * Registers the Bootstrap tooltip plugin.
	 * @param string $selector the CSS selector
	 * @param array $options the plugin options
	 * @see http://twitter.github.com/bootstrap/javascript.html#tooltip
	 * @since 0.9.8
	 */
	public function registerTooltip($selector = null, $options = array())
	{
		$this->registerPlugin(self::PLUGIN_TOOLTIP, $selector, $options, 'a[rel="tooltip"]');
	}

	/**
	 * Registers the Bootstrap typeahead plugin.
	 * @param string $selector the CSS selector
	 * @param array $options the plugin options
	 * @see http://twitter.github.com/bootstrap/javascript.html#typeahead
	 * @since 0.9.8
	 */
	public function registerTypeAHead($selector = null, $options = array())
	{
		$this->registerPlugin(self::PLUGIN_TYPEAHEAD, $selector, $options);
	}

	/**
	 * Returns whether a plugin is disabled in the plugin configuration.
	 * @param string $name the name of the plugin
	 * @return boolean the result
	 * @since 0.9.8
	 */
	protected function isPluginDisabled($name)
	{
		return isset($this->plugins[$name]) || (isset($this->plugins[$name]) && $this->plugins[$name] !== false);
	}

	/**
	 * Registers a Bootstrap JavaScript plugin.
	 * @param string $name the name of the plugin
	 * @param string $selector the CSS selector
	 * @param array $options the plugin options
	 * @param string $defaultSelector the default selector to use
	 * @since 0.9.8
	 */
	protected function registerPlugin($name, $selector = null, $options = array(), $defaultSelector = null)
	{
		if (!$this->isPluginRegistered($name))
		{
			$this->registerScriptFile("bootstrap-{$name}.js");
			$this->_rp[$name] = true;
		}

		if (!isset($selector) && empty($options))
		{
			// Initialization from extension configuration.
			$config = isset($this->plugins[$name]) ? $this->plugins[$name] : array();

			if (isset($config['selector']))
				$selector = $config['selector'];

			if (isset($config['options']))
				$options = $config['options'];

			if (!isset($selector))
				$selector = $defaultSelector;
		}

		if (isset($selector))
		{
			$key = __CLASS__.'.'.md5($name.$selector.serialize($options).$defaultSelector);
			$options = !empty($options) ? CJavaScript::encode($options) : '';
			Yii::app()->clientScript->registerScript($key, "jQuery('{$selector}').{$name}({$options});");
		}
	}

	/**
	 * Registers a JavaScript file in the assets folder.
	 * @param string $fileName the file name.
     * @param integer $position the position of the JavaScript file.
	 */
	protected function registerScriptFile($fileName, $position=CClientScript::POS_END)
	{
		Yii::app()->clientScript->registerScriptFile($this->getAssetsUrl().'/js/'.$fileName, $position);
	}

	/**
	* Returns the URL to the published assets folder.
	* @return string the URL
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
