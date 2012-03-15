<?php
require_once(Yii::getPathOfAlias('ext.assetManager.vendors.less').DIRECTORY_SEPARATOR.'LessParser.php');

/**
 * Sass class
 * @package			PHamlP
 * @subpackage	Yii
 */
class Less {
	/**
	 * @var SassParser
	 */
	private $less;

	/**
	 * Constructor
	 * @param array Sass options
	 * @return Sass
	 */
	public function __construct($options)
    {
	    $this->less = new LessParser();
        foreach ($options as $key => $val)
        {
            $this->less->{$key} = $val;
        }
	}

	/**
	 * Parse a Sass file to CSS
	 * @param string path to file
	 * @return string CSS
	 */
	public function parse($file)
    {
	    return $this->less->parse($file);
	}
}