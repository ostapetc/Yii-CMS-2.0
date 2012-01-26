<?php
/**
 * Image_Toolbox.class.php -- PHP image manipulation class
 *
 * Copyright (C) 2003 Martin Theimer <pappkamerad@decoded.net>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License <http://www.opensource.org/gpl-license.html>
 * for more details..
 *
 * The latest version of Image_Toolbox can be obtained from:
 * http://sourceforge.net/projects/image-toolbox
 * http://www.phpclasses.org/image_toolbox
 *
 * @author Martin Theimer <pappkamerad@decoded.net>
 * @copyright Copyright (C) 2003 Martin Theimer
 * @version 1.1.0
 * @package Image_Toolbox
 * @link http://sourceforge.net/projects/image-toolbox
 */
 
// $Id: Image_Toolbox.class.php,v 1.9 2003/12/05 19:34:01 pappkamerad Exp $

if (!defined('IMAGE_TOOLBOX_DEFAULT_JPEG_QUALITY')) {
	define('IMAGE_TOOLBOX_DEFAULT_JPEG_QUALITY', 75);
}
if (!defined('IMAGE_TOOLBOX_DEFAULT_8BIT_COLORS')) {
	define('IMAGE_TOOLBOX_DEFAULT_8BIT_COLORS', 256);
}
if (!defined('IMAGE_TOOLBOX_BIAS_HORIZONTAL')) {
	define('IMAGE_TOOLBOX_BIAS_HORIZONTAL', 1);
}
if (!defined('IMAGE_TOOLBOX_BIAS_VERTICAL')) {
	define('IMAGE_TOOLBOX_BIAS_VERTICAL', 0);
}
if (!defined('IMAGE_TOOLBOX_BLEND_COPY')) {
	define('IMAGE_TOOLBOX_BLEND_COPY', 1);
}
if (!defined('IMAGE_TOOLBOX_BLEND_MULTIPLY')) {
	define('IMAGE_TOOLBOX_BLEND_MULTIPLY', 2);
}
if (!defined('IMAGE_TOOLBOX_BLEND_SCREEN')) {
	define('IMAGE_TOOLBOX_BLEND_SCREEN', 3);
}
if (!defined('IMAGE_TOOLBOX_BLEND_DIFFERENCE')) {
	define('IMAGE_TOOLBOX_BLEND_DIFFERENCE', 4);
}
if (!defined('IMAGE_TOOLBOX_BLEND_NEGATION')) {
	define('IMAGE_TOOLBOX_BLEND_NEGATION', 5);
}
if (!defined('IMAGE_TOOLBOX_BLEND_EXCLUTION')) {
	define('IMAGE_TOOLBOX_BLEND_EXCLUSION', 6);
}
if (!defined('IMAGE_TOOLBOX_BLEND_OVERLAY')) {
	define('IMAGE_TOOLBOX_BLEND_OVERLAY', 7);
}

/**
 * PHP image manipulation class
 *
 * This class provides an easy to use library to the PHP GD-based imagefunctions
 *
 * @author Martin Theimer <pappkamerad@decoded.net>
 * @copyright 2003, Martin Theimer
 * @package Image_Toolbox
 * @link http://sourceforge.net/projects/image-toolbox
 * @version 1.1.0
 */
class Image_Toolbox {

    /**
     * The prefix for every error message
     * 
     * @access private
     * @var string
     */
	var $_error_prefix = 'Image: ';
	
	/**
     * Defines imagetypes and how they are supported by the server
     * 
     * @access private
     * @var array
     */
	var $_types = array (
		1 => array (
			'ext' => 'gif',
			'mime' => 'image/gif',
			'supported' => 0
		),
		2 => array (
			'ext' => 'jpg',
			'mime' => 'image/jpeg',
			'supported' => 0
		),
		3 => array (
			'ext' => 'png',
			'mime' => 'image/png',
			'supported' => 0
		)
	);
	
	/**
     * Which PHP image resize function to be used
     * imagecopyresampled only supported with GD >= 2.0
     * 
     * @access private
     * @var string
     */
	var $_resize_function = 'imagecopyresampled';

	/**
     * Stores all image resource data
     * 
     * @access private
     * @var array
     */
	var $_img = array (
		'main' => array (
			'resource' => 0,
			'width' => 0,
			'height' => 0,
			'bias' => 0,
			'aspectratio' => 0,
			'type' => 0,
			'output_type' => 0,
			'indexedcolors' => 0,
			'color' => -1
		)
	);
	
	/**
     * Which PHP image create function to be used
     * imagecreatetruecolor only supported with GD >= 2.0
     * 
     * @access private
     * @var string
     */
	var $_imagecreatefunction = '';
	
    /**
     * The class constructor.
     *
     * Determines the image features of the server and sets the according values.<br>
     * Additionally you can specify a image to be created/loaded. like {@link addImage() addImage}.
     * 
     * If no parameter is given, no image resource will be generated<br>
     * Or:<br>
     * <i>string</i> <b>$file</b> imagefile to load<br>
     * Or:<br>
     * <i>integer</i> <b>$width</b> imagewidth of new image to be created<br>
     * <i>integer</i> <b>$height</b> imageheight of new image to be created<br>
     * <i>string</i> <b>$fillcolor</b> optional fill the new image with this color (hexformat, e.g. '#FF0000')<br>
     */
	function Image_Toolbox() {
		$args = func_get_args();
		$argc = func_num_args();
		
		//get GD information. see what types we can handle
		$gd_info = function_exists('gd_info') ? gd_info() : $this->_gd_info();
		preg_match("/\A[\D]*([\d+\.]*)[\D]*\Z/", $gd_info['GD Version'], $matches);
		list($this->_gd_version_string, $this->_gd_version_number) = $matches;
		$this->_gd_version = substr($this->_gd_version_number, 0, strpos($this->_gd_version_number, '.'));
		if ($this->_gd_version >= 2) {
			$this->_imagecreatefunction = 'imagecreatetruecolor';
			$this->_resize_function = 'imagecopyresampled';
		} else {
			$this->_imagecreatefunction = 'imagecreate';
			$this->_resize_function = 'imagecopyresized';
		}
						
		$this->_gd_ttf = $gd_info['FreeType Support'];
		$this->_gd_ps = $gd_info['T1Lib Support'];
		if ($gd_info['GIF Read Support']) {
			$this->_types[1]['supported'] = 1;
			if ($gd_info['GIF Create Support']) {
				$this->_types[1]['supported'] = 2;
			}
		}
		
		if ((isset($gd_info['JPG Support']) && $gd_info['JPG Support']) || (isset($gd_info['JPEG Support']) && $gd_info['JPEG Support'])) {
			$this->_types[2]['supported'] = 2;
		}
		if ($gd_info['PNG Support']) {
			$this->_types[3]['supported'] = 2;
		}
		
		//load or create main image
		if ($argc == 0) {
			return true;
		} else {
			if ($this->_addImage($argc, $args)) {
				foreach ($this->_img['operator'] as $key => $value) {
					$this->_img['main'][$key] = $value;
				}
				$this->_img['main']['output_type'] = $this->_img['main']['type'];
				unset($this->_img['operator']);
				return true;
			} else {
				trigger_error($this->_error_prefix . 'No appropriate constructor found.', E_USER_ERROR);
				return null;
			}
		}
	}

	/**
     * Returns an assocative array with information about the image features of this server
     *
     * Array values:
     * <ul>
     * <li>'gd_version' -> what GD version is installed on this server (e.g. 2.0)</li>
     * <li>'gif' -> 0 = not supported, 1 = reading is supported, 2 = creating is supported</li>
     * <li>'jpg' -> 0 = not supported, 1 = reading is supported, 2 = creating is supported</li>
     * <li>'png' -> 0 = not supported, 1 = reading is supported, 2 = creating is supported</li>
     * <li>'ttf' -> TTF text creation. true = supported, false = not supported
     * </ul>
     *
     * @return array
     */ 
	function getServerFeatures() {
		$features = array();
		$features['gd_version'] = $this->_gd_version_number;
		$features['gif'] = $this->_types[1]['supported'];
		$features['jpg'] = $this->_types[2]['supported'];
		$features['png'] = $this->_types[3]['supported'];
		$features['ttf'] = $this->_gd_ttf;
		return $features;
	}

	/**
     * Flush all image resources and init a new one
     *
     * Parameter:<br>
     * <i>string</i> <b>$file</b> imagefile to load<br>
     * Or:<br>
     * <i>integer</i> <b>$width</b> imagewidth of new image to be created<br>
     * <i>integer</i> <b>$height</b> imageheight of new image to be created<br>
     * <i>string</i> <b>$fillcolor</b> optional fill the new image with this color (hexformat, e.g. '#FF0000')<br>
     */ 
	function newImage() {
		$args = func_get_args();
		$argc = func_num_args();
		
		if ($this->_addImage($argc, $args)) {
			foreach ($this->_img['operator'] as $key => $value) {
				$this->_img['main'][$key] = $value;
			}
			$this->_img['main']['output_type'] = $this->_img['main']['type'];
			unset($this->_img['operator']);
			return true;
		} else {
			trigger_error($this->_error_prefix . 'No appropriate constructor found.', E_USER_ERROR);
			return null;
		}
	}

	/**
     * Reimplements the original PHP {@link gd_info()} function for older PHP versions
     * 
     * @access private
     * @return array associative array with info about the GD library of the server
     */ 
	function _gd_info() {
		$array = array(
        	"GD Version" => "",
			"FreeType Support" => false,
			"FreeType Linkage" => "",
			"T1Lib Support" => false,
			"GIF Read Support" => false,
			"GIF Create Support" => false,
			"JPG Support" => false,
			"PNG Support" => false,
			"WBMP Support" => false,
			"XBM Support" => false
		);
        
		$gif_support = 0;
		ob_start();
		eval("phpinfo();");
		$info = ob_get_contents();
		ob_end_clean();
      
		foreach(explode("\n", $info) as $line) {
			if(strpos($line, "GD Version") !== false)
				$array["GD Version"] = trim(str_replace("GD Version", "", strip_tags($line)));
			if(strpos($line, "FreeType Support") !== false)
				$array["FreeType Support"] = trim(str_replace("FreeType Support", "", strip_tags($line)));
			if(strpos($line, "FreeType Linkage") !== false)
				$array["FreeType Linkage"] = trim(str_replace("FreeType Linkage", "", strip_tags($line)));
			if(strpos($line, "T1Lib Support") !== false)
				$array["T1Lib Support"] = trim(str_replace("T1Lib Support", "", strip_tags($line)));
			if(strpos($line, "GIF Read Support") !== false)
				$array["GIF Read Support"] = trim(str_replace("GIF Read Support", "", strip_tags($line)));
			if(strpos($line, "GIF Create Support") !== false)
				$array["GIF Create Support"] = trim(str_replace("GIF Create Support", "", strip_tags($line)));
			if(strpos($line, "GIF Support") !== false)
				$gif_support = trim(str_replace("GIF Support", "", strip_tags($line)));
			if(strpos($line, "JPG Support") !== false)
				$array["JPG Support"] = trim(str_replace("JPG Support", "", strip_tags($line)));
			if(strpos($line, "PNG Support") !== false)
				$array["PNG Support"] = trim(str_replace("PNG Support", "", strip_tags($line)));
			if(strpos($line, "WBMP Support") !== false)
				$array["WBMP Support"] = trim(str_replace("WBMP Support", "", strip_tags($line)));
			if(strpos($line, "XBM Support") !== false)
				$array["XBM Support"] = trim(str_replace("XBM Support", "", strip_tags($line)));
		}
        
		if($gif_support === "enabled") {
			$array["GIF Read Support"] = true;
			$array["GIF Create Support"] = true;
		}

		if($array["FreeType Support"] === "enabled") {
			$array["FreeType Support"] = true;
		}
 
        if($array["T1Lib Support"] === "enabled") {
            $array["T1Lib Support"] = true;
        }
       
		if($array["GIF Read Support"] === "enabled") {
			$array["GIF Read Support"] = true;
		}
 
		if($array["GIF Create Support"] === "enabled") {
			$array["GIF Create Support"] = true;
		}

		if($array["JPG Support"] === "enabled") {
			$array["JPG Support"] = true;
		}
            
		if($array["PNG Support"] === "enabled") {
			$array["PNG Support"] = true;
		}
            
		if($array["WBMP Support"] === "enabled") {
			$array["WBMP Support"] = true;
		}
            
		if($array["XBM Support"] === "enabled") {
			$array["XBM Support"] = true;
		}

		return $array;
    }

	/**
     * Convert a color defined in hexvalues to the PHP color format
     * 
     * @access private
     * @param string $hex color value in hexformat (e.g. '#FF0000')
     * @return integer color value in PHP format
     */ 
	function _hexToPHPColor($hex) {
		$length = strlen($hex);
		$dr = hexdec(substr($hex, $length - 6, 2));
		$dg = hexdec(substr($hex, $length - 4, 2));
		$db = hexdec(substr($hex, $length - 2, 2));
		$color = ($dr << 16) + ($dg << 8) + $db;
		return $color;
	}
	
	/**
     * Convert a color defined in hexvalues to corresponding dezimal values
     * 
     * @access private
     * @param string $hex color value in hexformat (e.g. '#FF0000')
     * @return array associative array with color values in dezimal format (fields: 'red', 'green', 'blue')
     */ 
	function _hexToDecColor($hex) {
		$length = strlen($hex);
		$color['red'] = hexdec(substr($hex, $length - 6, 2));
		$color['green'] = hexdec(substr($hex, $length - 4, 2));
		$color['blue'] = hexdec(substr($hex, $length - 2, 2));
		return $color;
	}

	/**
     * Generate a new image resource based on the given parameters
     *
     * Parameter:
     * <i>string</i> <b>$file</b> imagefile to load<br>
     * Or:<br>
     * <i>integer</i> <b>$width</b> imagewidth of new image to be created<br>
     * <i>integer</i> <b>$height</b> imageheight of new image to be created<br>
     * <i>string</i> <b>$fillcolor</b> optional fill the new image with this color (hexformat, e.g. '#FF0000')<br>
     *
     * @access private
     */
	function _addImage($argc, $args) {
		if (($argc == 2 || $argc == 3) && is_int($args[0]) && is_int($args[1]) && (is_string($args[2]) || !isset($args[2]))) {
			//neues leeres bild mit width und height (fillcolor optional)
			$this->_img['operator']['width'] = $args[0];
            $this->_img['operator']['height'] = $args[1];
            ($this->_img['operator']['width'] >= $this->_img['operator']['height']) ? ($this->_img['operator']['bias'] = IMAGE_TOOLBOX_BIAS_HORIZONTAL) : ($this->_img['operator']['bias'] = IMAGE_TOOLBOX_BIAS_VERTICAL);
            $this->_img['operator']['aspectratio'] = $this->_img['operator']['width'] / $this->_img['operator']['height'];
            $this->_img['operator']['indexedcolors'] = 0;
            $functionname = $this->_imagecreatefunction;
            $this->_img['operator']['resource'] = $functionname($this->_img['operator']['width'], $this->_img['operator']['height']);
            // set default type jpg.
            $this->_img['operator']['type'] = 2;
            if (isset($args[2]) && is_string($args[2])) {
            	//neues bild mit farbe f�llen
            	$fillcolor = $this->_hexToPHPColor($args[2]);
            	imagefill($this->_img['operator']['resource'], 0, 0, $fillcolor);
            	$this->_img['operator']['color'] = $fillcolor;
            } else {
            	$this->_img['operator']['color'] = 0;
			}
		} elseif ($argc == 1 && is_string($args[0])) {
			//bild aus datei laden. width und height original gr�sse
			$this->_img['operator'] = $this->_loadFile($args[0]);
			$this->_img['operator']['indexedcolors'] = imagecolorstotal($this->_img['operator']['resource']);
			$this->_img['operator']['color'] = -1;
		} else {
			return false;
		}
		return true;
	}

	/**
     * Loads a image file
     *
     * @access private
     * @param string $filename imagefile to load
     * @return array associative array with the loaded filedata
     */
	function _loadFile($filename) {
		if (file_exists($filename)) {
			$info = getimagesize($filename);
			
			if (!$info)
			{
				trigger_error($this->_error_prefix . 'Not an image ('.$filename.').', E_USER_ERROR);
				return null;
			}
			
			$filedata['width'] = $info[0];
			$filedata['height'] = $info[1];
			($filedata['width'] >= $filedata['height']) ? ($filedata['bias'] = IMAGE_TOOLBOX_BIAS_HORIZONTAL) : ($filedata['bias'] = IMAGE_TOOLBOX_BIAS_VERTICAL);
           	$filedata['aspectratio'] = $filedata['width'] / $filedata['height'];
			$filedata['type'] = $info[2];

			if ($this->_types[$filedata['type']]['supported'] < 1) {
				trigger_error($this->_error_prefix . 'Imagetype ('.$this->_types[$filedata['type']]['ext'].') not supported for reading.', E_USER_ERROR);
				return null;
			}
			switch ($filedata['type']) {
				case 1:
					$dummy = imagecreatefromgif($filename);
					$functionname = $this->_imagecreatefunction;
					$filedata['resource'] = $functionname($filedata['width'], $filedata['height']);
					imagecopy($filedata['resource'], $dummy, 0, 0, 0, 0, $filedata['width'], $filedata['height']);
					imagedestroy($dummy);
					break;
					
				case 2:
					$filedata['resource'] = imagecreatefromjpeg($filename);
					break;
					
				case 3:
					$dummy = imagecreatefrompng($filename);
					if (imagecolorstotal($dummy) != 0) {
						$functionname = $this->_imagecreatefunction;
						$filedata['resource'] = $functionname($filedata['width'], $filedata['height']);
						imagecopy($filedata['resource'], $dummy, 0, 0, 0, 0, $filedata['width'], $filedata['height']);
					} else {
						$filedata['resource'] = $dummy;
					}
					unset($dummy);
					break;
					
				default:
					trigger_error($this->_error_prefix . 'Imagetype not supported.', E_USER_ERROR);
					return null;
			}
			return $filedata;
		} else {
			trigger_error($this->_error_prefix . 'Imagefile (' . $filename . ') does not exist.', E_USER_ERROR);
			return null;
		}
	}
	
	/**
     * Output a image to the browser
     *
     * $output_type can be one of the following:<br>
     * <ul>
     * <li>'gif' -> gif image (if supported) (8-bit indexed colors)</li>
     * <li>'png' -> png image (if supported) (truecolor)</li>
     * <li>'png8' -> png image (if supported) (8-bit indexed colors)</li>
     * <li>'jpg' -> jpeg image (if supported) (truecolor)</li>
     * </ul>
     * (default: same as original)
     *
     * $dither:<br>
     * If this is true than dither is used on the conversion from truecolor to 8-bit indexed imageformats (png8, gif)<br>
     * (default = false)
     *
     * @param string|integer $output_type type of outputted image
     * @param integer $output_quality jpeg quality of outputted image (default: IMAGE_TOOLBOX_DEFAULT_JPEG_QUALITY)
     * @param bool $dither use dither
     * @return bool true on success, otherwise false
     */
	function output($output_type = false, $output_quality = false, $dither = false) {
		if ($output_type === false) {
			$output_type = $this->_img['main']['output_type'];
		}
		switch ($output_type) {
			case 1:
			case 'gif':
			case 'GIF':
				if ($this->_types[1]['supported'] < 2) {
					trigger_error($this->_error_prefix . 'Imagetype ('.$this->_types[$output_type]['ext'].') not supported for creating/writing.', E_USER_ERROR);
					return null;
				}
				header ('Content-type: ' . $this->_types[$output_type]['mime']);
				if ($this->_gd_version >= 2) {
					if ($this->_img['main']['indexedcolors'] == 0) {
						$dummy = imagecreatetruecolor($this->_img['main']['width'], $this->_img['main']['height']);
						imagecopy($dummy, $this->_img['main']['resource'], 0, 0, 0, 0, $this->_img['main']['width'], $this->_img['main']['height']);
						if ($output_quality === false) {
							$output_quality = IMAGE_TOOLBOX_DEFAULT_8BIT_COLORS;
						}
						imagetruecolortopalette($dummy, $dither, $output_quality);
					}
					imagegif($dummy);
					imagedestroy($dummy);
				}
				else {
					imagegif($this->_img['main']['resource']);
				}
				break;
			
			case 2:
			case '2':
			case 'jpg':
			case 'jpeg':
			case 'JPG':
			case 'JPEG':
				if ($this->_types[2]['supported'] < 2) {
					trigger_error($this->_error_prefix . 'Imagetype ('.$this->_types[$output_type]['ext'].') not supported for creating/writing.', E_USER_ERROR);
					return null;
				}
				header ('Content-type: ' . $this->_types[$output_type]['mime']);
				if ($output_quality === false) {
					$output_quality = IMAGE_TOOLBOX_DEFAULT_JPEG_QUALITY;
				}
				imagejpeg($this->_img['main']['resource'], '', $output_quality);
				break;
				
			case 3:
			case '3':
			case 'png':
			case 'PNG':
			case 'png24':
			case 'PNG24':
				if ($this->_types[3]['supported'] < 2) {
					trigger_error($this->_error_prefix . 'Imagetype ('.$this->_types[$output_type]['ext'].') not supported for creating/writing.', E_USER_ERROR);
					return null;
				}
				header ('Content-type: ' . $this->_types[$output_type]['mime']);
				imagepng($this->_img['main']['resource']);
				break;
				
			case 4:
			case '4':
			case 'png8':
			case 'PNG8':
				if ($this->_types[3]['supported'] < 2) {
					trigger_error($this->_error_prefix . 'Imagetype ('.$this->_types[$output_type]['ext'].') not supported for creating/writing.', E_USER_ERROR);
					return null;
				}
				header ('Content-type: ' . $this->_types[$output_type]['mime']);
				if ($this->_gd_version >= 2) {
					if ($this->_img['main']['indexedcolors'] == 0) {
						$dummy = imagecreatetruecolor($this->_img['main']['width'], $this->_img['main']['height']);
						imagecopy($dummy, $this->_img['main']['resource'], 0, 0, 0, 0, $this->_img['main']['width'], $this->_img['main']['height']);
						if ($output_quality === false) {
							$output_quality = IMAGE_TOOLBOX_DEFAULT_8BIT_COLORS;
						}
						imagetruecolortopalette($dummy, $dither, $output_quality);
					}
					imagepng($dummy);
					imagedestroy($dummy);
				}
				else {
					imagepng($this->_img['main']['resource']);
				}
				break;
				
			default:
				trigger_error($this->_error_prefix . 'Output-Imagetype not supported.', E_USER_ERROR);
				return null;
		}
		return true;
	}
	
	/**
     * Save a image to disk
     *
     * $output_type can be one of the following:<br>
     * <ul>
     * <li>'gif' -> gif image (if supported) (8-bit indexed colors)</li>
     * <li>'png' -> png image (if supported) (truecolor)</li>
     * <li>'png8' -> png image (if supported) (8-bit indexed colors)</li>
     * <li>'jpg' -> jpeg image (if supported) (truecolor)</li>
     * </ul>
     * (default: same as original)
     *
     * $dither:<br>
     * If this is true than dither is used on the conversion from truecolor to 8-bit indexed imageformats (png8, gif)<br>
     * (default = false)
     *
     * @param string $filename filename of saved image
     * @param string|integer $output_type type of saved image
     * @param integer $output_quality jpeg quality of saved image (default: IMAGE_TOOLBOX_DEFAULT_JPEG_QUALITY)
     * @param bool $dither use dither
     * @return bool true on success, otherwise false
     */
	function save($filename, $output_type = false, $output_quality = false, $dither = false) {
		if ($output_type === false) {
			$output_type = $this->_img['main']['output_type'];
		}
		switch ($output_type) {
			case 1:
			case 'gif':
			case 'GIF':
				if ($this->_types[1]['supported'] < 2) {
					trigger_error($this->_error_prefix . 'Imagetype ('.$this->_types[$output_type]['ext'].') not supported for creating/writing.', E_USER_ERROR);
					return null;
				}
				if ($this->_gd_version >= 2) {
					if ($this->_img['main']['indexedcolors'] == 0) {
						$dummy = imagecreatetruecolor($this->_img['main']['width'], $this->_img['main']['height']);
						imagecopy($dummy, $this->_img['main']['resource'], 0, 0, 0, 0, $this->_img['main']['width'], $this->_img['main']['height']);
						if ($output_quality === false) {
							$output_quality = IMAGE_TOOLBOX_DEFAULT_8BIT_COLORS;
						}
						imagetruecolortopalette($dummy, $dither, $output_quality);
					}
					imagegif($dummy, $filename);
					imagedestroy($dummy);
				}
				else {
					imagegif($this->_img['main']['resource']);
				}
				break;
			
			case 2:
			case '2':
			case 'jpg':
			case 'jpeg':
			case 'JPG':
			case 'JPEG':
				if ($this->_types[2]['supported'] < 2) {
					trigger_error($this->_error_prefix . 'Imagetype ('.$this->_types[$output_type]['ext'].') not supported for creating/writing.', E_USER_ERROR);
					return null;
				}
				if ($output_quality === false) {
					$output_quality = IMAGE_TOOLBOX_DEFAULT_JPEG_QUALITY;
				}
				imagejpeg($this->_img['main']['resource'], $filename, $output_quality);
				break;
				
			case 3:
			case '3':
			case 'png':
			case 'PNG':
			case 'png24':
			case 'PNG24':
				if ($this->_types[3]['supported'] < 2) {
					trigger_error($this->_error_prefix . 'Imagetype ('.$this->_types[$output_type]['ext'].') not supported for creating/writing.', E_USER_ERROR);
					return null;
				}
				header ('Content-type: ' . $this->_types[$output_type]['mime']);
				imagepng($this->_img['main']['resource'], $filename);
				break;
				
			case 4:
			case '4':
			case 'png8':
			case 'PNG8':
				if ($this->_types[3]['supported'] < 2) {
					trigger_error($this->_error_prefix . 'Imagetype ('.$this->_types[$output_type]['ext'].') not supported for creating/writing.', E_USER_ERROR);
					return null;
				}
				if ($this->_gd_version >= 2) {
					if ($this->_img['main']['indexedcolors'] == 0) {
						$dummy = imagecreatetruecolor($this->_img['main']['width'], $this->_img['main']['height']);
						imagecopy($dummy, $this->_img['main']['resource'], 0, 0, 0, 0, $this->_img['main']['width'], $this->_img['main']['height']);
						if ($output_quality === false) {
							$output_quality = IMAGE_TOOLBOX_DEFAULT_8BIT_COLORS;
						}
						imagetruecolortopalette($dummy, $dither, $output_quality);
					}
					imagepng($dummy, $filename);
					imagedestroy($dummy);
				}
				else {
					imagepng($this->_img['main']['resource'], $filename);
				}
				break;
				
			default:
				trigger_error($this->_error_prefix . 'Output-Imagetype not supported.', E_USER_ERROR);
				return null;
		}
		return true;
	}
	
	/**
     * Sets the resize method of choice
     * 
     * $method can be one of the following:<br>
     * <ul>
     * <li>'resize' -> supported by every version of GD (fast but ugly resize of image)</li>
     * <li>'resample' -> only supported by GD version >= 2.0 (slower but antialiased resize of image)</li>
     * <li>'workaround' -> supported by every version of GD (workaround function for bicubic resizing, downsizing, VERY slow!, taken from php.net comments)</li>
     * <li>'workaround2' -> supported by every version of GD (alternative workaround function for bicubic resizing, down- and upsizing, VERY VERY slow!, taken from php.net comments)</li>
     * </ul>
     *
     * @param string|integer $method resize method
     * @return bool true on success, otherwise false
     */
	function setResizeMethod($method) {
		switch ($method) {
			case 1:
			case '1':
			case 'resize':
				$this->_resize_function = 'imagecopyresized';
				break;
				
			case 2:
			case '2':
			case 'resample':
				if (!function_exists('imagecopyresampled')) {
					// no error message. just return false.
					return null;
				}
				$this->_resize_function = 'imagecopyresampled';
				break;
				
			case 3:
			case '3':
			case 'resample_workaround':
			case 'workaround':
			case 'bicubic':
				$this->_resize_function = '$this->_imageCopyResampledWorkaround';
				break;
				
			case 4:
			case '4':
			case 'resample_workaround2':
			case 'workaround2':
			case 'bicubic2':
				$this->_resize_function = '$this->_imageCopyResampledWorkaround2';
				break;
				
			default:
				trigger_error($this->_error_prefix . 'Resizemethod not supported.', E_USER_ERROR);
				return null;
		}
		return true;
	}
	
	/**
     * Resize the current image
     * 
     * if $width = 0 the new width will be calculated from the $height value preserving the correct aspectratio.<br>
     *
     * if $height = 0 the new height will be calculated from the $width value preserving the correct aspectratio.<br>
     *
     * $mode can be one of the following:<br>
     * <ul>
     * <li>0 -> image will be resized to the new output size, regardless of the original aspectratio. (default)</li>
     * <li>1 -> image will be cropped if necessary to preserve the aspectratio and avoid image distortions.</li>
     * <li>2 -> image will be resized preserving its original aspectratio. differences to the new outputsize will be filled with $bgcolor</li>
     * </ul>
     *
     * if $autorotate is set to true the given $width and $height values may "change place" if the given image bias is different from the original one.<br>
     * if either $width or $height is 0, the new size will be applied to either the new width or the new height based on the bias value of the original image.<br>
     * (default = false)
     *
     * @param integer $width new width of image
     * @param integer $height new height of image
     * @param integer $mode resize mode
     * @param bool $autorotate use autorotating
     * @param string $bgcolor background fillcolor (hexformat, e.g. '#FF0000')
     * @return bool true on success, otherwise false
     */
	function newOutputSize($width, $height, $mode = 0, $autorotate = false, $bgcolor = '#000000') {
		if ($width > 0 && $height > 0 && is_int($width) && is_int($height)) {
			//ignore aspectratio
			if (!$mode) {
				//do not crop to get correct aspectratio
				($width >= $height) ? ($this->_img['target']['bias'] = IMAGE_TOOLBOX_BIAS_HORIZONTAL) : ($this->_img['target']['bias'] = IMAGE_TOOLBOX_BIAS_VERTICAL);
				if ($this->_img['main']['bias'] == $this->_img['target']['bias'] || !$autorotate) {
					$this->_img['target']['width'] = $width;
					$this->_img['target']['height'] = $height;
				} else {
					$this->_img['target']['width'] = $height;
					$this->_img['target']['height'] = $width;
				}
				$this->_img['target']['aspectratio'] = $this->_img['target']['width'] / $this->_img['target']['height'];
				
				$cpy_w = $this->_img['main']['width'];
				$cpy_h = $this->_img['main']['height'];
				$cpy_w_offset = 0;
				$cpy_h_offset = 0;
			} elseif ($mode == 1) {
				//crop to get correct aspectratio
				($width >= $height) ? ($this->_img['target']['bias'] = IMAGE_TOOLBOX_BIAS_HORIZONTAL) : ($this->_img['target']['bias'] = IMAGE_TOOLBOX_BIAS_VERTICAL);
				if ($this->_img['main']['bias'] == $this->_img['target']['bias'] || !$autorotate) {
					$this->_img['target']['width'] = $width;
					$this->_img['target']['height'] = $height;
				} else {
					$this->_img['target']['width'] = $height;
					$this->_img['target']['height'] = $width;
				}
				$this->_img['target']['aspectratio'] = $this->_img['target']['width'] / $this->_img['target']['height'];
				
				if ($this->_img['main']['width'] / $this->_img['target']['width'] >= $this->_img['main']['height'] / $this->_img['target']['height']) {
					$cpy_h = $this->_img['main']['height'];
					$cpy_w = (integer) $this->_img['main']['height'] * $this->_img['target']['aspectratio'];
					$cpy_w_offset = (integer) ($this->_img['main']['width'] - $cpy_w) / 2;
					$cpy_h_offset = 0;
				} else {
					$cpy_w = $this->_img['main']['width'];
					$cpy_h = (integer) $this->_img['main']['width'] / $this->_img['target']['aspectratio'];
					$cpy_h_offset = (integer) ($this->_img['main']['height'] - $cpy_h) / 2;
					$cpy_w_offset = 0;
				}
			}
			elseif ($mode == 2) {
				//fill remaining background with a color to keep aspectratio
				$final_aspectratio = $width / $height;
				if ($final_aspectratio < $this->_img['main']['aspectratio']) {
					$this->_img['target']['width'] = $width;
					$this->_img['target']['height'] = (integer) $width / $this->_img['main']['aspectratio'];
					$cpy_w_offset2 = 0;
					$cpy_h_offset2 = (integer) (($height - $this->_img['target']['height']) / 2);
				}
				else {
					$this->_img['target']['height'] = $height;
					$this->_img['target']['width'] = (integer) $height * $this->_img['main']['aspectratio'];
					$cpy_h_offset2 = 0;
					$cpy_w_offset2 = (integer) (($width - $this->_img['target']['width']) / 2);
				}
				$this->_img['target']['aspectratio'] = $this->_img['main']['aspectratio'];
				$cpy_w = $this->_img['main']['width'];
				$cpy_h = $this->_img['main']['height'];
				$cpy_w_offset = 0;
				$cpy_h_offset = 0;
			}
		} elseif (($width == 0 && $height > 0) || ($width > 0 && $height == 0) && is_int($width) && is_int($height)) {
			//keep aspectratio
			if ($autorotate == true) {
				if ($this->_img['main']['bias'] == IMAGE_TOOLBOX_BIAS_HORIZONTAL && $width > 0) {
					$height = $width;
					$width = 0;
				} elseif ($this->_img['main']['bias'] == IMAGE_TOOLBOX_BIAS_VERTICAL && $height > 0) {
					$width = $height;
					$height = 0;
				}
			}
			($width >= $height) ? ($this->_img['target']['bias'] = IMAGE_TOOLBOX_BIAS_HORIZONTAL) : ($this->_img['target']['bias'] = IMAGE_TOOLBOX_BIAS_VERTICAL);
			if ($width != 0) {
				$this->_img['target']['width'] = $width;
				$this->_img['target']['height'] = (integer) $width / $this->_img['main']['aspectratio'];
			} else {
				$this->_img['target']['height'] = $height;
				$this->_img['target']['width'] = (integer) $height * $this->_img['main']['aspectratio'];
			}
			$this->_img['target']['aspectratio'] = $this->_img['main']['aspectratio'];
			
			$cpy_w = $this->_img['main']['width'];
			$cpy_h = $this->_img['main']['height'];
			$cpy_w_offset = 0;
			$cpy_h_offset = 0;
		} else {
			trigger_error($this->_error_prefix . 'Outputwidth and -height must be integers greater zero.', E_USER_ERROR);
			return null;
		}
		
		//create resized picture
		$functionname = $this->_imagecreatefunction;
		$dummy = $functionname($this->_img['target']['width'] + 1, $this->_img['target']['height'] + 1);
		eval($this->_resize_function . '($dummy, $this->_img["main"]["resource"], 0, 0, $cpy_w_offset, $cpy_h_offset, $this->_img["target"]["width"], $this->_img["target"]["height"], $cpy_w, $cpy_h);');
		if ($mode == 2) {
			$this->_img['target']['resource'] = $functionname($width, $height);
			$fillcolor = $this->_hexToPHPColor($bgcolor);
            imagefill($this->_img['target']['resource'], 0, 0, $fillcolor);
		} else {
			$this->_img['target']['resource'] = $functionname($this->_img['target']['width'], $this->_img['target']['height']);
			$cpy_w_offset2 = 0;
			$cpy_h_offset2 = 0;
		}
		imagecopy($this->_img['target']['resource'], $dummy, $cpy_w_offset2, $cpy_h_offset2, 0, 0, $this->_img['target']['width'], $this->_img['target']['height']);
		imagedestroy($dummy);
		
		if ($mode == 2) {
			$this->_img['target']['width'] = $width;
            $this->_img['target']['height'] = $height;
        }
		//update _img['main'] with new data
		foreach ($this->_img['target'] as $key => $value) {
			$this->_img['main'][$key] = $value;
		}
		unset ($this->_img['target']);
		
		return true;
	}

	/**
     * Adds a new image resource based on the given parameters.
     *
     * It does not overwrite the existing image resource.<br>
     * Instead it is used to load a second image to merge with the existing image.
     *
     * Parameter:<br>
     * <i>string</i> <b>$file</b> imagefile to load<br>
     * Or:<br>
     * <i>integer</i> <b>$width</b> imagewidth of new image to be created<br>
     * <i>integer</i> <b>$height</b> imageheight of new image to be created<br>
     * <i>string</i> <b>$fillcolor</b> optional fill the new image with this color (hexformat, e.g. '#FF0000')<br>
     */	
	function addImage() {
		$args = func_get_args(); 
		$argc = func_num_args();
		
		if ($this->_addImage($argc, $args)) {
			return true;
		} else {
			trigger_error($this->_error_prefix . 'failed to add image.', E_USER_ERROR);
			return false;
		}
	}
	
	/**
     * Blend two images.
     *
     * Original image and the image loaded with {@link addImage() addImage}<br>
     * NOTE: This operation can take very long and is not intended for realtime use.
     * (but of course depends on the power of your server :) )
     *
     * IMPORTANT: {@link imagecopymerge() imagecopymerged} doesn't work with PHP 4.3.2. Bug ID: {@link http://bugs.php.net/bug.php?id=24816 24816}<br>
     *
     * $x:<br>
     * negative values are possible.<br>
     * You can also use the following keywords ('left', 'center' or 'middle', 'right').<br>
     * Additionally you can specify an offset in pixel with the keywords like this 'left +10'.<br>
     * (default = 0)
     *
     * $y:<br>
     * negative values are possible.<br>
     * You can also use the following keywords ('top', 'center' or 'middle', 'bottom').<br>
     * Additionally you can specify an offset in pixel with the keywords like this 'bottom -10'.<br>
     * (default = 0)
     *
     * Possible values for $mode:
     * <ul>
     *  <li>IMAGE_TOOLBOX_BLEND_COPY</li>
     *  <li>IMAGE_TOOLBOX_BLEND_MULTIPLY</li>
     *  <li>IMAGE_TOOLBOX_BLEND_SCREEN</li>
     *  <li>IMAGE_TOOLBOX_BLEND_DIFFERENCE</li>
     *  <li>IMAGE_TOOLBOX_BLEND_EXCLUSION</li>
     *  <li>IMAGE_TOOLBOX_BLEND_OVERLAY</li>
     * </ul>
     *
     * $percent:<br>
     * alpha value in percent of blend effect (0 - 100)<br>
     * (default = 100)
     *
     * @param string|integer $x Horizontal position of second image. 
     * @param integer $y Vertical position of second image. negative values are possible.
     * @param integer $mode blend mode.
     * @param integer $percent alpha value
     */	
	function blend($x = 0, $y = 0, $mode = IMAGE_TOOLBOX_BLEND_COPY, $percent = 100) {
		if (is_string($x) || is_string($y)) {
			list($xalign, $xalign_offset) = explode(" ", $x);
			list($yalign, $yalign_offset) = explode(" ", $y);
		}
		if (is_string($x)) {
			switch ($xalign) {
				case 'left':
					$dst_x = 0 + $xalign_offset;
					$src_x = 0;
					$src_w = $this->_img['operator']['width'];
					break;
					
				case 'right':
					$dst_x = ($this->_img['main']['width'] - $this->_img['operator']['width']) + $xalign_offset;
					$src_x = 0;
					$src_w = $this->_img['operator']['width'];
					break;
					
				case 'middle':
				case 'center':
					$dst_x = (($this->_img['main']['width'] / 2) - ($this->_img['operator']['width'] / 2)) + $yalign_offset;
					$src_x = 0;
					$src_w = $this->_img['operator']['width'];
					break;
			}
		} else {
			if ($x >= 0) {
				$dst_x = $x;
				$src_x = 0;
				$src_w = $this->_img['operator']['width'];
			} else {
				$dst_x = 0;
				$src_x = abs($x);
				$src_w = $this->_img['operator']['width'] - $src_x;
			}
		}
		if (is_string($y)) {
			switch ($yalign) {
				case 'top':
					$dst_y = 0 + $yalign_offset;
					$src_y = 0;
					$src_h = $this->_img['operator']['height'];
					break;
					
				case 'bottom':
					$dst_y = ($this->_img['main']['height'] - $this->_img['operator']['height']) + $yalign_offset;
					$src_y = 0;
					$src_h = $this->_img['operator']['height'];
					break;
					
				case 'middle':
				case 'center':
					$dst_y = (($this->_img['main']['height'] / 2) - ($this->_img['operator']['height'] / 2)) + $yalign_offset;
					$src_y = 0;
					$src_h = $this->_img['operator']['height'];
					break;
			}
		} else {
			if ($y >= 0) {
				$dst_y = $y;
				$src_y = 0;
				$src_h = $this->_img['operator']['height'];
			} else {
				$dst_y = 0;
				$src_y = abs($y);
				$src_h = $this->_img['operator']['height'] - $src_y;
			}
		}
		$this->_imageBlend($mode, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $percent);
		return true;
	}
	
	/**
     * Blend two images.
     *
     * @access private
     */	
	function _imageBlend($mode, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $percent) {
		if ($mode == IMAGE_TOOLBOX_BLEND_COPY) {
			if ($percent == 100) {
				imagecopy($this->_img['main']['resource'], $this->_img['operator']['resource'], $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h);
			} else {
				imagecopymerge($this->_img['main']['resource'], $this->_img['operator']['resource'], $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $percent);
			}
		} else {
			$functionname = $this->_imagecreatefunction;
			$dummy = $functionname($src_w, $src_h);
			for ($y=0; $y < $src_h; $y++) {
				for ($x=0; $x < $src_w; $x++) {
					$colorindex = imagecolorat($this->_img['main']['resource'], $dst_x + $x, $dst_y + $y);
					$colorrgb1 = imagecolorsforindex($this->_img['main']['resource'], $colorindex);
					$colorindex = imagecolorat($this->_img['operator']['resource'], $src_x + $x, $src_y + $y);
					$colorrgb2 = imagecolorsforindex($this->_img['operator']['resource'], $colorindex);
					$colorblend = $this->_calculateBlendvalue($mode, $colorrgb1, $colorrgb2);
					$newcolor = imagecolorallocate($dummy, $colorblend['red'], $colorblend['green'], $colorblend['blue']);
					imagesetpixel($dummy, $x, $y, $newcolor);
				}
			}
		
			$this->_img['target']['resource'] = $functionname($this->_img['main']['width'], $this->_img['main']['height']);
			imagecopy($this->_img['target']['resource'], $this->_img['main']['resource'], 0, 0, 0, 0, $this->_img['main']['width'], $this->_img['main']['height']);
			imagecopymerge($this->_img['target']['resource'], $dummy, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $percent);
									
			$this->_img['main']['resource'] = $this->_img['target']['resource'];
			unset($this->_img['target']);
		}
	}
	
	/**
     * Calculate blend values for given blend mode
     *
     * @access private
     */	
	function _calculateBlendvalue($mode, $colorrgb1, $colorrgb2) {
		switch ($mode) {
			case IMAGE_TOOLBOX_BLEND_MULTIPLY:
				$c['red'] = ($colorrgb1['red'] * $colorrgb2['red']) >> 8;
				$c['green'] = ($colorrgb1['green'] * $colorrgb2['green']) >> 8;
				$c['blue'] = ($colorrgb1['blue'] * $colorrgb2['blue']) >> 8;
				break;
			
			case IMAGE_TOOLBOX_BLEND_SCREEN:
				$c['red'] = 255 - ((255 - $colorrgb1['red']) * (255 - $colorrgb2['red']) >> 8);
				$c['green'] = 255 - ((255 - $colorrgb1['green']) * (255 - $colorrgb2['green']) >> 8);
				$c['blue'] = 255 - ((255 - $colorrgb1['blue']) * (255 - $colorrgb2['blue']) >> 8);
				break;
			
			case IMAGE_TOOLBOX_BLEND_DIFFERENCE:
				$c['red'] = abs($colorrgb1['red'] - $colorrgb2['red']);
				$c['green'] = abs($colorrgb1['green'] - $colorrgb2['green']);
				$c['blue'] = abs($colorrgb1['blue'] - $colorrgb2['blue']);
				break;
			
			case IMAGE_TOOLBOX_BLEND_NEGATION:	
				$c['red'] = 255 - abs(255 - $colorrgb1['red'] - $colorrgb2['red']);
				$c['green'] = 255 - abs(255 - $colorrgb1['green'] - $colorrgb2['green']);
				$c['blue'] = 255 - abs(255 - $colorrgb1['blue'] - $colorrgb2['blue']);
				break;
				
			case IMAGE_TOOLBOX_BLEND_EXCLUTION:	
				$c['red'] = $colorrgb1['red'] + $colorrgb2['red'] - (($colorrgb1['red'] * $colorrgb2['red']) >> 7);
				$c['green'] = $colorrgb1['green'] + $colorrgb2['green'] - (($colorrgb1['green'] * $colorrgb2['green']) >> 7);
				$c['blue'] = $colorrgb1['blue'] + $colorrgb2['blue'] - (($colorrgb1['blue'] * $colorrgb2['blue']) >> 7);
				break;
				
			case IMAGE_TOOLBOX_BLEND_OVERLAY:			
				if ($colorrgb1['red'] < 128) {
					$c['red']= ($colorrgb1['red'] * $colorrgb2['red']) >> 7;
				} else {
					$c['red'] = 255 - ((255 - $colorrgb1['red']) * (255 - $colorrgb2['red']) >> 7);
				}
				if ($colorrgb1['green'] < 128) {
					$c['green'] = ($colorrgb1['green'] * $colorrgb2['green']) >> 7;
				} else {
					$c['green'] = 255 - ((255 - $colorrgb1['green']) * (255 - $colorrgb2['green']) >> 7);
				}
				if ($colorrgb1['blue'] < 128) {
					$c['blue'] = ($colorrgb1['blue'] * $colorrgb2['blue']) >> 7;
				} else {
					$c['blue'] = 255 - ((255 - $colorrgb1['blue']) * (255 - $colorrgb2['blue']) >> 7);
				}
				break;
				
			default:
				break;
		}
		return $c;
	}
	
	/**
     * convert iso character coding to unicode (PHP conform)
     * needed for TTF text generation of special characters (Latin-2)
     *
     * @access private
     */	
	function _iso2uni($isoline) {
		$iso2uni = array(
			173 => "&#161;",
			155 => "&#162;",
			156 => "&#163;",
			15 => "&#164;",
			157 => "&#165;",
			124 => "&#166;",
			21 => "&#167;",
			249 => "&#168;",
			184 => "&#169;",
			166 => "&#170;",
			174 => "&#171;",
			170 => "&#172;",
			169 => "&#174;",
			238 => "&#175;",
			248 => "&#176;",
			241 => "&#177;",
			253 => "&#178;",
			252 => "&#179;",
			239 => "&#180;",
			230 => "&#181;",
			20 => "&#182;",
			250 => "&#183;",
			247 => "&#184;",
			251 => "&#185;",
			167 => "&#186;",
			175 => "&#187;",
			172 => "&#188;",
			171 => "&#189;",
			243 => "&#190;",
			168 => "&#191;",
			183 => "&#192;",
			181 => "&#193;",
			182 => "&#194;",
			199 => "&#195;",
			142 => "&#196;",
			143 => "&#197;",
			146 => "&#198;",
			128 => "&#199;",
			212 => "&#200;",
			144 => "&#201;",
			210 => "&#202;",
			211 => "&#203;",
			141 => "&#204;",
			161 => "&#205;",
			140 => "&#206;",
			139 => "&#207;",
			209 => "&#208;",
			165 => "&#209;",
			227 => "&#210;",
			224 => "&#211;",
			226 => "&#212;",
			229 => "&#213;",
			153 => "&#214;",
			158 => "&#215;",
			157 => "&#216;",
			235 => "&#217;",
			233 => "&#218;",
			234 => "&#219;",
			154 => "&#220;",
			237 => "&#221;",
			232 => "&#222;",
			225 => "&#223;",
			133 => "&#224;",
			160 => "&#225;",
			131 => "&#226;",
			198 => "&#227;",
			132 => "&#228;",
			134 => "&#229;",
			145 => "&#230;",
			135 => "&#231;",
			138 => "&#232;",
			130 => "&#233;",
			136 => "&#234;",
			137 => "&#235;",
			141 => "&#236;",
			161 => "&#237;",
			140 => "&#238;",
			139 => "&#239;",
			208 => "&#240;",
			164 => "&#241;",
			149 => "&#242;",
			162 => "&#243;",
			147 => "&#244;",
			228 => "&#245;",
			148 => "&#246;",
			246 => "&#247;",
			155 => "&#248;",
			151 => "&#249;",
			163 => "&#250;",
			150 => "&#251;",
			129 => "&#252;",
			236 => "&#253;",
			231 => "&#254;",
			152 => "&#255;"
		);
		for ($i=0; $i < strlen($isoline); $i++){
			$thischar = substr($isoline, $i, 1);
			$new = $iso2uni[ord($thischar)];
			$uniline .= ($new != "") ? $new : $thischar;
		}
		return $uniline;
	}

	/**
     * Writes text over the image
     *
     * only TTF fonts are supported at the moment
     *
     * $x:<br>
     * You can also use the following keywords ('left', 'center' or 'middle', 'right').<br>
     * Additionally you can specify an offset in pixel with the keywords like this 'left +10'.<br>
     * (default = 0)
     *
     * $y:<br>
     * You can also use the following keywords ('top', 'center' or 'middle', 'bottom').<br>
     * Additionally you can specify an offset in pixel with the keywords like this 'bottom -10'.<br>
     * (default = 0)
     *
     * @param string $text text to be generated.
     * @param string $font TTF fontfile to be used. (relative paths are ok).
     * @param integer $size textsize.
     * @param string $color textcolor in hexformat (e.g. '#FF0000').
     * @param string|integer $x horizontal postion in pixel.
     * @param string|integer $y vertical postion in pixel.
     * @param integer $angle rotation of the text.
     */	
	function addText($text, $font, $size, $color, $x, $y, $angle = 0) {
		global $HTTP_SERVER_VARS;
		
		if (substr($font, 0, 1) == DIRECTORY_SEPARATOR || (substr($font, 1, 1) == ":" && (substr($font, 2, 1) == "\\" || substr($font, 2, 1) == "/"))) {
			$prepath = '';
		} else {
			$prepath = substr($HTTP_SERVER_VARS['SCRIPT_FILENAME'], 0, strrpos($HTTP_SERVER_VARS['SCRIPT_FILENAME'], DIRECTORY_SEPARATOR)) . DIRECTORY_SEPARATOR;
		}
		$text = $this->_iso2uni($text);
		if (is_string($x) || is_string($y)) {
			$textsize = imagettfbbox($size, $angle, $prepath.$font, $text);
			$textwidth = abs($textsize[2]);
			$textheight = abs($textsize[7]);
			list($xalign, $xalign_offset) = explode(" ", $x);
			list($yalign, $yalign_offset) = explode(" ", $y);
		}
		if (is_string($x)) {
			switch ($xalign) {
				case 'left':
					$x = 0 + $xalign_offset;
					break;
					
				case 'right':
					$x = ($this->_img['main']['width'] - $textwidth) + $xalign_offset;
					break;
					
				case 'middle':
				case 'center':
					$x = (($this->_img['main']['width'] - $textwidth) / 2) + $xalign_offset;
					break;
			}
		}
		if (is_string($y)) {
			switch ($yalign) {
				case 'top':
					$y = (0 + $textheight) + $yalign_offset;
					break;
					
				case 'bottom':
					$y = ($this->_img['main']['height']) + $yalign_offset;
					break;
					
				case 'middle':
				case 'center':
					$y = ((($this->_img['main']['height'] - $textheight) / 2) + $textheight) + $yalign_offset;
					break;
			}
		}
		imagettftext($this->_img['main']['resource'], $size, $angle, $x, $y, $this->_hexToPHPColor($color), $prepath . $font, $text);
		return true;
	}
	
	/**
     * workaround function for bicubic resizing. works well for downsizing only. VERY slow. taken from php.net comments
     *
     * @access private
     */	
	function _imageCopyResampledWorkaround(&$dst_img, &$src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) {
		/*
		for ($i = 0; $i < imagecolorstotal($src_img); $i++)
		{
			$colors = ImageColorsForIndex ($src_img, $i);
			ImageColorAllocate ($dst_img, $colors['red'],$colors['green'], $colors['blue']);
		}
		*/
		$scaleX = ($src_w - 1) / $dst_w;
		$scaleY = ($src_h - 1) / $dst_h;

		$scaleX2 = $scaleX / 2.0;
		$scaleY2 = $scaleY / 2.0;

		for ($j = $src_y; $j < $src_y + $dst_h; $j++) {
			$sY = $j * $scaleY;
			for ($i = $src_x; $i < $src_x + $dst_w; $i++) {
				$sX = $i * $scaleX;

				$c1 = ImageColorsForIndex($src_img, ImageColorAt($src_img, (int) $sX, (int) $sY + $scaleY2));
				$c2 = ImageColorsForIndex($src_img, ImageColorAt($src_img, (int) $sX, (int) $sY));
				$c3 = ImageColorsForIndex($src_img, ImageColorAt($src_img, (int) $sX + $scaleX2, (int) $sY + $scaleY2));
				$c4 = ImageColorsForIndex($src_img, ImageColorAt($src_img, (int) $sX + $scaleX2, (int) $sY));

				$red = (integer) (($c1['red'] + $c2['red'] + $c3['red'] + $c4['red']) / 4);
				$green = (integer) (($c1['green'] + $c2['green'] + $c3['green'] + $c4['green']) / 4);
				$blue = (integer) (($c1['blue'] + $c2['blue'] + $c3['blue'] + $c4['blue']) / 4);

				$color = ImageColorClosest ($dst_img, $red, $green,$blue);
				ImageSetPixel ($dst_img, $dst_x + $i - $src_x, $dst_y + $j - $src_y,$color);
			}
		}
	}

	/**
     * alternative workaround function for bicubic resizing. works well for downsizing and upsizing. VERY VERY slow. taken from php.net comments
     *
     * @access private
     */	
	function _imageCopyResampledWorkaround2(&$dst_img, &$src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) {
		ImagePaletteCopy ($dst_img, $src_img);
		$rX = $src_w / $dst_w;
		$rY = $src_h / $dst_h;
		$w = 0;
		for ($y = $dst_y; $y < $dst_h; $y++) {
			$ow = $w; $w = round(($y + 1) * $rY);
			$t = 0;
			for ($x = $dst_x; $x < $dst_w; $x++) {
				$r = $g = $b = 0; $a = 0;
				$ot = $t; $t = round(($x + 1) * $rX);
				for ($u = 0; $u < ($w - $ow); $u++) {
					for ($p = 0; $p < ($t - $ot); $p++) {
						$c = ImageColorsForIndex ($src_img, ImageColorAt ($src_img, $ot + $p, $ow + $u));
						$r += $c['red'];
						$g += $c['green'];
						$b += $c['blue'];
						$a++;
					}
				}
				ImageSetPixel ($dst_img, $x, $y, ImageColorClosest ($dst_img, $r / $a, $g / $a, $b / $a)); 
			}
		}
	} 
}
