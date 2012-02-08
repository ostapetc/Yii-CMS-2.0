<?php
/**
 * BootNavbar class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('bootstrap.widgets.BootWidget');

/**
 * Bootstrap navigation widget with support for dropdown menus.
 * @since 0.9.7
 * @todo Add collapse support. http://twitter.github.com/bootstrap/javascript.html#collapse
 */
class BootNavbar extends BootWidget
{
	/**
	 * @var string the text for the brand.
	 */
	public $brand;
	/**
	 * @var string the URL for the brand link.
	 */
	public $brandUrl;
	/**
	 * @var array the HTML attributes for the brand link.
	 */
	public $brandOptions = array();
	/**
	 * @var array navigation items.
	 * @since 0.9.8
	 */
	public $items = array();
	/**
	 * @var boolean flag that indicates if the nav should use the full width available. Defaults to false.
	 * @since 0.9.8
	 */
	public $fluid = false;
	/**
	 * @var boolean flag that indicates if the nav bar should be fixed to the top of the page. Defaults to true.
	 * @since 0.9.8
	 */
	public $fixed = true;

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		if (!isset($this->brand))
			$this->brand = CHtml::encode(Yii::app()->name);

		if (!isset($this->brandUrl))
			$this->brandUrl = Yii::app()->homeUrl;
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		if (isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] .= ' navbar';
		else
			$this->htmlOptions['class'] = 'navbar';

		if ($this->fixed)
			$this->htmlOptions['class'] .= ' navbar-fixed-top';

		if (isset($this->brandOptions['class']))
			$this->brandOptions['class'] .= ' brand';
		else
			$this->brandOptions['class'] = 'brand';

		if (isset($this->brandUrl))
			$this->brandOptions['href'] = $this->brandUrl;

		$containerCssClass = $this->fluid ? 'container-fluid' : 'container';

		echo CHtml::openTag('div', $this->htmlOptions);
		echo '<div class="navbar-inner"><div class="'.$containerCssClass.'">';
		echo '<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"></a>';

        if ($this->brand)
            echo CHtml::openTag('a', $this->brandOptions).$this->brand.'</a>';
        
		echo '<div class="nav-collapse">';

		foreach ($this->items as $item)
		{
			if (is_string($item))
				echo $item;
			else
			{
				if (!isset($item['class']))
					$item['class'] = 'bootstrap.widgets.BootMenu';

				$className = $item['class'];
				unset($item['class']);

				$this->controller->widget($className, $item);
			}
		}

		echo '</div></div></div></div>';
	}
}
