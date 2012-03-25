<?php
/* SVN FILE: $Id: SassException.php 61 2010-04-16 10:19:59Z chris.l.yates $ */
/**
 * Sass exception.
 * @author			Chris Yates <chris.l.yates@gmail.com>
 * @copyright 	Copyright (c) 2010 PBM Web Development
 * @license			http://assetManager.googlecode.com/files/license.txt
 * @package			PHamlP
 * @subpackage	Sass
 */


/**
 * Sass exception class.
 * @package			PHamlP
 * @subpackage	Sass
 */
class SassException extends CException {
	/**
	 * Sass Exception.
	 * @param string Exception message
	 * @param array parameters to be applied to the message using <code>strtr</code>.
	 * @param object object with source code and meta data
	 */
    public function __construct($message, $params, $object) {
        parent::__construct(Yii::t('sass', $message, $params) .
                (is_object($object) ? ": {$object->filename}::{$object->line}\nSource: {$object->source}" : '')
        );
    }
}