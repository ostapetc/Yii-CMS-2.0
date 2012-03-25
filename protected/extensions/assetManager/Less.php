<?php
Yii::import('ext.assetManager.vendors.less.*');

/**
 * Less class
 * @subpackage	Yii
 */
class Less {
	/**
	 * @var SassParser
	 */
	private $less;
    private $options;
	/**
	 * Constructor
	 * @param array Less options
	 * @return Less
	 */
	public function __construct($options)
    {
        $this->options = $options;
	}

	/**
	 * Parse a Sass file to CSS
	 * @param string path to file
	 * @return string CSS
	 */
	public function parse($file)
    {
        $lessc = new lessc($file, $this->options);
        return $lessc->parse();
	}
}