<?php
/**
 * RImgrWidget class file.
 *
 * @author Viacheslav Rudnev <slava.rudnev@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
/**
 * 
 * IMGr wrapper around {@link http://www.steamdev.com/imgr/ IMGr}.
 *
 * IMGr is a jQuery plugin for rounding image corners.
 * The script utilizes CSS3 in modern web browsers, and VML in Internet Explorer 8 and below.
 * 
 * Usage:
 * <pre>
 * $this->widget('ext.imgr.RImgrWidget',array(
 *     // IMGr {@link http://www.steamdev.com/imgr/ options}
 *     'target' => 'img',
 *     'options' => array(
 *			'radius' => '10px',
 *			'size' => '0px',
 *			'color' => '#000',
 *			'style' => 'solid',
 *		),
 * ));
 * </pre>

 * @author Viacheslav Rudnev <slava.rudnev@gmail.com>
 * @version 0.1
 * @package imgr
 * @link http://www.steamdev.com/imgr/
 */
class RImgrWidget extends CWidget
{

	/**
	 * @var string
	 */
	public $packageName = 'imgr';

	/**
	 * jQuery selector
	 * @var string
	 */
	public $target = 'img';

	/**
	 * IMGr {@link http://www.steamdev.com/imgr/ options}
	 * @var array(
	 * 		<i>radius</i> - Any quoted ("") pixel value
	 * Shorthand guide:
	 * "A" - A(tl tr br bl)
	 * "A B" - A(tl tr) B(bl br)
	 * "A B C" - A(tl) B(tr) C(bl br)
	 * "A B C D" - A(tl) B(tr) C(br) D(bl)
	 * 
	 * 		<i>size</i> - Any quoted ("") pixel value
	 * 
	 * 		<i>color</i> - Any quoted ("") hex color value or any color name (ie. "red", "green", "blue")
	 * 
	 * 		<i>style</i> - "solid", "dashed", "dotted", "double"
	 * )
	 */
	public $options = array(
		'radius' => '10px',
		'size' => '0px',
		'color' => '#000',
		'style' => 'solid',
	);

	/**
	 * Init widget.
	 */
	public function init()
	{
		$this->getPackage();
	}

	/**
	 * Run widget.
	 */
	public function run()
	{
		$this->registerClientScript();
	}

	/**
	 * @return array
	 */
	protected function getPackage()
	{
		/**
		 * @var CClientScript $cs
		 */
		$cs = Yii::app()->getClientScript();

		if(!isset($cs->packages[$this->packageName]))
			$cs->packages[$this->packageName] = array(
				'basePath' => dirname(__FILE__) . '/assets',
				'js' => array('jquery.imgr' . (YII_DEBUG ? '' : '.min') . '.js',),
				'depends' => array('jquery',),
			);

		// Publish package assets. Force copy assets in debug mode.
		if(!isset($cs->packages[$this->packageName]['baseUrl']))
		{
			$cs->packages[$this->packageName]['baseUrl'] = Yii::app()->getAssetManager()
				->publish($cs->packages[$this->packageName]['basePath'], false, -1);
		}

		return $cs->packages[$this->packageName];
	}

	/**
	 * Register Script.
	 */
	protected function registerClientScript()
	{
		Yii::app()->getClientScript()
			->registerPackage($this->packageName)
			->registerScript(
				__CLASS__ . '#' . $this->getId(), 'jQuery(' . CJavaScript::encode($this->target) . ').imgr(' . CJavaScript::encode($this->options) . ');'
		);
	}

}