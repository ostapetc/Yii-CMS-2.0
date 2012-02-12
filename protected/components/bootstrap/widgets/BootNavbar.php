<?php
/**
 * BootNavbar class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

Yii::import('bootstrap.widgets.BootWidget');

/**
 * Bootstrap navigation bar widget.
 * @since 0.9.7
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
	 * @var boolean whether the nav span over the full width. Defaults to false.
	 * @since 0.9.8
	 */
	public $fluid = false;
	/**
	 * @var boolean whether the nav bar is fixed to the top of the page. Defaults to true.
	 * @since 0.9.8
	 */
	public $fixed = true;
	/**
	 * @var boolean whether to enable collapsing on narrow screens. Default to false.
	 */
	public $collapse = false;

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		if (!$this->brand)
		{
			$this->brand = CHtml::encode(Yii::app()->name);

			if (!isset($this->brandUrl))
				$this->brandUrl = Yii::app()->homeUrl;
		}

		if ($this->collapse)
			Yii::app()->bootstrap->registerCollapse();
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
		else
			$this->htmlOptions['class'] .= ' navbar-static';

		if (isset($this->brandOptions['class']))
			$this->brandOptions['class'] .= ' brand';
		else
			$this->brandOptions['class'] = 'brand';

		if (isset($this->brandUrl))
			$this->brandOptions['href'] = $this->brandUrl;

		$containerCssClass = $this->fluid ? 'container-fluid' : 'container';

		echo CHtml::openTag('div', $this->htmlOptions);
		echo '<div class="navbar-inner"><div class="'.$containerCssClass.'">';

		if ($this->collapse)
		{
			echo '<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">';
			echo '<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>';
			echo '</a>';
		}

        if ($this->brand !== false)
            echo CHtml::openTag('a', $this->brandOptions).$this->brand.'</a>';

		if ($this->collapse)
			echo '<div class="nav-collapse">';

		foreach ($this->items as $item)
		{
			if (is_string($item))
				echo $item;
			else
			{
				if (isset($item['class']))
				{
					$className = $item['class'];
					unset($item['class']);

					$this->controller->widget($className, $item);
				}
			}
		}

		if ($this->collapse)
			echo '</div>';

		echo '</div></div></div>';
	}
}
