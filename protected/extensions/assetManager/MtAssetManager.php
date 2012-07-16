<?php
/**
 * Script to combine and shrink js and css files.
 * Using google closure compiler for js and yuicompressor for css files
 * It's mandatory to have java available
 *
 * ATTENTION:
 * =========
 * Always use relative paths in your javascript and css files
 * because the location will different later.
 *
 * For example:
 * -----------
 * background: url(../icon.png);
 *
 * @category  Yii_Extension
 * @package   mintaoHelperScripts
 * @author    Florian Fackler <florian.fackler@mintao.com>
 * @copyright 2010 mintao GmbH & Co. KG
 * @license   Proprietary. All rights reserved
 * @version   $Id: mtClientScript 2010-09-08T16:10:37+02:00florian.fackler
 * @link      http://mintao.com
 */

define('DS', DIRECTORY_SEPARATOR);

class mtClientScript extends CClientScript
{
    /**
     * @var array files to exclude from beeing combined and compressed
     */
    public $excludeFiles = array();

    /**
     * @var bool exclude asset files like core scripts
     */
    public $excludeAssets = false;

    /**
     * @var string Absolute file path to java
     */
    public $javaPath = '/usr/bin/java';

    /**
     * @var string Absolute file path to yui compressor
     */
    public $yuicPath = null;

    /**
     * @var string Absolute file path to google closure compiler
     */
    public $closurePath = null;

    /**
     * @var string 'WHITESPACE_ONLY' | 'SIMPLE_OPTIMIZATIONS' | 'ADVANCED_OPTIMIZATIONS'
     */
    public $closureConfig = 'SIMPLE_OPTIMIZATIONS';

    /**
     * @var array list of cdn hosts
     */
    public $cdn = array();
    /**
     * @var array list of file => host
     */
    public $fileToHost;

    private $_defaultCssMedia = 'screen, projection';
    private $_baseUrl = '';
    private $_basePath = '';
    private $_assetsPath = '';

    public function init()
    {
        parent::init();
        if (!is_executable($this->javaPath)) {
            throw new Exception('Java not found or not accessable');
        }
        if (!is_readable($this->yuicPath)) {
            $this->yuicPath = dirname(__FILE__) . DS . 'yuicompressor-2.4.2.jar';
        }
        if (!is_readable($this->closurePath)) {
            $this->closurePath = dirname(__FILE__) . DS . 'compiler.jar';
        }
        if (!file_exists($this->yuicPath)) {
            throw new Exception('YUI compressor not found');
        }
        if (!file_exists($this->closurePath)) {
            throw new Exception('Google closure compiler not found');
        }

        $this->_baseUrl = Yii::app()->baseUrl;
        $this->_basePath = YiiBase::getPathOfAlias('webroot');
        $this->_assetsPath = $this->_basePath . str_replace($this->_baseUrl, '', $this->getCoreScriptUrl());
    }

    /**
     * Extension description
     *
     * @return string Description
     * @author Florian Fackler
     */
    public function setDescription()
    {
        return 'This plugin combines and shrinks all js and css files';
    }

    public function getPositions() {
        return array(self::POS_BEGIN, self::POS_READY, self::POS_LOAD, self::POS_HEAD, self::POS_END);
    }

    public function isAsset($url) {
        return strpos($url, $this->getCoreScriptUrl()) === 0;
    }

    /**
     * @param string the output to be inserted with scripts.
     */
    public function renderHead(&$output) {
        // combine css files
        if (count($this->cssFiles) > 0) {
            $cssFiles = array();
            foreach ($this->cssFiles as $url => $media) {
                if (
                    !($this->excludeAssets && $this->isAsset($url)) &&
                    !in_array(basename($url), $this->excludeFiles)
                ) {
                    $cssFiles[$media ? strtolower($media) : $this->_defaultCssMedia][] = $url;
                }
            }

            foreach ($cssFiles as $media => $urls) {
                $outfile = $this->combineFiles('css', $urls);
                foreach ($urls as $url) {
                    $this->scriptMap[basename($url)] = $this->getCoreScriptUrl() . '/' . $outfile;
                }
            }
        }

        // combine js files
        if ($this->enableJavaScript) {
            foreach($this->getPositions() as $p) {
                if (isset($this->scriptFiles[$p])) {
                    $combine = array();
                    foreach ($this->scriptFiles[$p] as $url) {
                        if (
                            !($this->excludeAssets && $this->isAsset($url)) &&
                            !in_array(basename($url), $this->excludeFiles)
                        ) {
                            $combine[] = $url;
                        }
                    }
                    if ($combine) {
                        $outfile = $this->combineFiles('js', $combine);
                        foreach ($combine as $url) {
                            $this->scriptMap[basename($url)] = $this->getCoreScriptUrl() . '/' . $outfile;
                        }
                    }
                }
            }
        }
        $this->remapScripts();
        parent::renderHead($output);
    }

    /**
     * Inserts the scripts at the end of the body section.
     * @param string $output the output to be inserted with scripts.
     */
    public function renderBodyEnd(&$output)
    {
        if(!isset($this->scriptFiles[self::POS_END]) && !isset($this->scripts[self::POS_END])
            && !isset($this->scripts[self::POS_READY]) && !isset($this->scripts[self::POS_LOAD]) && !isset($this->scriptFiles[self::POS_LOAD]))
            return;
        $fullPage=0;
        $output=preg_replace('/(<\\/body\s*>)/is','<###end###>$1',$output,1,$fullPage);
        $html='';
        if(isset($this->scriptFiles[self::POS_END]))
        {
            foreach($this->scriptFiles[self::POS_END] as $scriptFile)
                $html.=CHtml::scriptFile($scriptFile)."\n";
        }
        if(isset($this->scriptFiles[self::POS_LOAD])) {
            // defer loading of scripts {@link http://code.google.com/speed/page-speed/docs/payload.html#DeferLoadingJS}
            if($fullPage) {
                $html.='<script type="text/javascript" charset="utf-8">
					// Add a script element as a child of the body
					function downloadJSAtOnload() {';
                foreach($this->scriptFiles[self::POS_LOAD] as $scriptFile) {
                    $html.='var element = document.createElement("script");
						element.src = "'.$scriptFile.'";
						document.body.appendChild(element);';
                }
                $html.='}'."\n";

                $html.='// Check for browser support of event handling capability
					if (window.addEventListener)
					window.addEventListener("load", downloadJSAtOnload, false);
					else if (window.attachEvent)
					window.attachEvent("onload", downloadJSAtOnload);
					else window.onload = downloadJSAtOnload;
					</script>'."\n";;
            }
        }
        $scripts=isset($this->scripts[self::POS_END]) ? $this->scripts[self::POS_END] : array();
        if(isset($this->scripts[self::POS_READY]))
        {
            if($fullPage)
                $scripts[]="jQuery(function($) {\n".implode("\n",$this->scripts[self::POS_READY])."\n});";
            else
                $scripts[]=implode("\n",$this->scripts[self::POS_READY]);
        }
        if(isset($this->scripts[self::POS_LOAD]))
        {
            if($fullPage)
                $scripts[]="jQuery(window).load(function() {\n".implode("\n",$this->scripts[self::POS_LOAD])."\n});";
            else
                $scripts[]=implode("\n",$this->scripts[self::POS_LOAD]);
        }
        if(!empty($scripts))
            $html.=CHtml::script(implode("\n",$scripts))."\n";

        if($fullPage)
            $output=str_replace('<###end###>',$html,$output);
        else
            $output=$output.$html;
    }

    /**
     * Returns one host per file, iterating through the hosts to distribute them evenly
     *
     * @param string $file
     * @return string
     */
    public function fileToHost($file) {
        if(!isset($this->fileToHost[$file])) {
            $this->fileToHost[$file] = current($this->cdn);
            if(!next($this->cdn)) reset($this->cdn);
        }
        return $this->fileToHost[$file];
    }

    /**
     * Combines, optimizes and compresses all given files
     *
     * @param string $type js or css
     * @param array $urls  array of url of the files
     * @param string $media optional, only relevant for css
     * @return string name of the resulting file
     * @author Florian Fackler
     */
    private function combineFiles($type, $urls) {
        if (!in_array($type, array('js', 'css'))) {
            throw new Exception('Only js or css as file type allowed');
        }

        // Create file paths
        $files = array();

        foreach ($urls as $url) {
            $filePath =
                $this->_basePath . str_replace($this->_baseUrl, '', $url);
            if (file_exists($filePath)) {
                $files[] = $filePath;
                $urlOfFile[$filePath] = explode('/', $url); // relative to WWWROOT without filename
            }
        }

        // Generate hash over modification dates
        $_hash = null;
        foreach ($files as $file) {
            $_hash .= $file . filemtime($file);
        }

        // File name of the combined file will be...
        $outFile = (!empty($this->cdn)?'cdn':'') . sha1($_hash) . '.' . $type;

        // Create new if not exists ( --disable-optimizations)
        if (!file_exists($this->_assetsPath . DS . $outFile)) {
            $joinedContent = '';

            foreach ($files as $file) {
                if(isset($urlOfFile[$file][1]) && $urlOfFile[$file][1] === 'themes') {
                    $theme = $urlOfFile[$file][1] . '/' . $urlOfFile[$file][2] . '/';
                } else {
                    $theme = '';
                }
                // Correct file path in css/js files :: MUST BE RELATIVE
                $content = file_get_contents($file);
                $content = str_replace('../', '../../' . $theme, $content);

                $search = array('/(\'\")^\//');
                $replace = array('$1' . '/var/www');

                if(!empty($this->cdn)) {
                    $search[] = '/url\([\'"]?(\/[^)\'"]+)[\'"]?\)/e'; // adds a host to absolute urls
                    $replace[] = '"url(http://" . $this->fileToHost("$1") . "$1)"';
                }

                $content = preg_replace($search, $replace, $content);
                $joinedContent .= $content;
            }
            $temp = $this->_basePath . DS . 'protected' . DS . 'runtime' . DS . $outFile;
            file_put_contents($temp, $joinedContent);
            unset($joinedContent);
            switch ($type) {
                case 'css':
                    $cmd = sprintf('%s -jar %s -o %s %s',
                        $this->javaPath,
                        $this->yuicPath,
                        $this->_assetsPath . DS . $outFile,
                        $temp);
                    break;
                case 'js':
                    $cmd = sprintf('%s -jar %s --js_output_file %s --compilation_level %s --js %s',
                        $this->javaPath,
                        $this->closurePath,
                        $this->_assetsPath . DS . $outFile,
                        $this->closureConfig,
                        $temp);
                    break;
            }
            $return = shell_exec($cmd);
        }

        return $outFile;
    }
}