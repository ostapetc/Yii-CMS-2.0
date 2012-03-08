<?php
/**
 * CClientScript class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CClientScript manages JavaScript and CSS stylesheets for views.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: CClientScript.php 2799 2011-01-01 19:31:13Z qiang.xue $
 * @package system.web
 * @since 1.0
 */
////////////////////////////////////////////////////////////////////////////////
/**
 * Extended Client Script Manager Class File
 *
 * @author Hightman <hightman2[at]yahoo[dot]com[dot]cn>
 * @link http://www.czxiu.com/
 * @copyright hightman
 * @license http://www.yiiframework.com/license/
 * @version 1.3
 *
 */
/**
  Requirements
  --------------
  Yii 1.1.x or above

  Description:
  --------------
  This extension just extend from {link: CClientScript} using few codes, it will allow you
  to automatically combine all script files and css files into a single (or several) script or css files.
  Basically this will reduce the HTTP calls for resources files by merging several resources files into
  a single (or more) files.
  It can automatically detect the required list of files, and generate a unique filename hash,
  so boldly ease of use.

  ####Css Files:
  CSS files are merged based on there media attribute, background images with a relative path
  in file can also be displayed correctly.

  ####Script files:
  Script files are merged based on their position, If you use the 'CClientScript::POS_HEAD'
  you will end up with a single file for all the script files you've used on that page.
  If you use 'CClientScript::POS_HEAD' and 'CClientScript::POS_END' for example then you'll
  end up with two files for each page on that request, Since those resources are located in different positions.

  ####File optmization or compress (EXPERIMENTAL, @since: 1.1)
  [CssMin](http://code.google.com/p/cssmin/) used to optmize merged css file. You can set property 'optmizeCssFiles' of the component to enable this feature.
  [JSMinPlus](http://crisp.tweakblogs.net/blog/1856/jsmin+-version-13.html) used to optimize merged script file. You can set property 'optmizeScriptFiles' of the component to enable this feature.

  Usage:
  ---------------

  Using this extension is as simple as adding the following code to the application configuration under the components array:

  ~~~
  [php]
  'clientScript' => array(
  'class' => 'ext.minify.EClientScript',
  'combineScriptFiles' => true, // By default this is set to false, set this to true if you'd like to combine the script files
  'combineCssFiles' => true, // By default this is set to false, set this to true if you'd like to combine the css files
  'optimizeScriptFiles' => false,       // @since: 1.1
  'optimizeCssFiles' => false,  // @since: 1.1
  ),
  ~~~

  Then you'd use the regular 'registerScriptFile' & 'registerCssFile' methods as normal and the files will be combined automatically.

  NOTE:
  ---------------
  If you registered some external resource files that not in the web application root directory, they will be kept and not combined.
  Compression or optmization is a EXPERIMENTAL feature, please use it carefully(@since: 1.1)

  ChangesLog:
  ---------------
  Nov 23, 2010
  * Skip the minimization of files whose names include `.pack.`
  * Add the last modification time as the QUERY_STRING to merged file, to avoid not properly flush the browser cache when the file updated.
  Nov 6, 2010
  * New version number 1.3
  * Not repeat the minimization of files those who have been minimized, whose names include `.min.`
  * Fixed `getRelativeUrl()` platform compatibility issue. (thanks to Troto)

  Known Issues:
  ----------------
  When some resource files can not be merged and strictly dependent on loading order, then may have some problem.

  Reporting Issue:
  -----------------
  Reporting Issues and comments are welcome, plz report them to offical forum of Yii.
  [Report issue](http://www.yiiframework.com/forum/index.php?/topic/12476-extension-eclientscript/)

 */
/**
 * Extended clientscript to automatically merge script and css files
 *
 * @author hightman <hightman2@yahoo.com.cn>
 * @version $Id $
 * @package extensions.minify
 * @since 1.0
 */
//class EClientScript extends CClientScript
//class CClientScript extends CApplicationComponent
class EClientScript extends CClientScript
{
        /**
         * The script is rendered in the head section right before the title element.
         */
        const POS_HEAD=0;
        /**
         * The script is rendered at the beginning of the body section.
         */
        const POS_BEGIN=1;
        /**
         * The script is rendered at the end of the body section.
         */
        const POS_END=2;
        /**
         * The script is rendered inside window onload function.
         */
        const POS_LOAD=3;
        /**
         * The body script is rendered inside a jQuery ready function.
         */
        const POS_READY=4;

        /**
         * @var boolean whether JavaScript should be enabled. Defaults to true.
         */
        public $enableJavaScript=true;
        /**
         * @var array the mapping between script file names and the corresponding script URLs.
         * The array keys are script file names (without directory part) and the array values are the corresponding URLs.
         * If an array value is false, the corresponding script file will not be rendered.
         * If an array key is '*.js' or '*.css', the corresponding URL will replace all
         * all JavaScript files or CSS files, respectively.
         *
         * This property is mainly used to optimize the generated HTML pages
         * by merging different scripts files into fewer and optimized script files.
         * @since 1.0.3
         */
        public $scriptMap=array();
        /**
         * @var array the registered CSS files (CSS URL=>media type).
         * @since 1.0.4
         */
        protected $cssFiles=array();
        protected $cssFilesOrder=array();
        /**
         * @var array the registered JavaScript files (position, key => URL)
         * @since 1.0.4
         */
        protected $scriptFiles=array();
        protected $scriptFilesOrder=array();
        /**
         * @var array the registered JavaScript code blocks (position, key => code)
         * @since 1.0.5
         */
        protected $scripts=array();
        protected $scriptsOrder=array();
        /**
         * @var array the register head meta tags. Each array element represents an option array
         * that will be passed as the last parameter of {@link CHtml::metaTag}.
         * @since 1.1.3
         */
        protected $metaTags=array();
        /**
         * @var array the register head link tags. Each array element represents an option array
         * that will be passed as the last parameter of {@link CHtml::linkTag}.
         * @since 1.1.3
         */
        protected $linkTags=array();
        /**
         * @var array the register css code blocks (key => array(CSS code, media type)).
         * @since 1.1.3
         */
        protected $css=array();
        protected $cssOrder=array();
        /**
         * @var integer Where the core scripts will be inserted in the page.
         * This can be one of the CClientScript::POS_* constants.
         * Defaults to CClientScript::POS_HEAD.
         * @since 1.1.3
         */
        public $coreScriptPosition=self::POS_HEAD;

        private $_hasScripts=false;
        private $_packages;
        private $_dependencies;
        private $_baseUrl;
        private $_coreScripts=array();
	private $_corePackages=array();

        /**
         * @var combined script file name
         */
        public $scriptFileName = 'script.js';
        /**
         * @var combined css stylesheet file name
         */
        public $cssFileName = 'style.css';
        /**
         * @var boolean if to combine the script files or not
         */
        public $combineScriptFiles = false;
        /**
         * @var boolean if to combine the css files or not
         */
        public $combineCssFiles = false;
        /**
         * @var boolean if to optimize the css files
         */
        public $optimizeCssFiles = false;
        /**
         * @var boolean if to optimize the script files via googleCompiler(this may cause to much slower)
         */
        public $optimizeScriptFiles = false;

        /**
         * Cleans all registered scripts.
         */
        public function reset()
        {
                $this->_hasScripts=false;
                $this->_coreScripts=array();
                $this->cssFiles=array();
                $this->css=array();
                $this->scriptFiles=array();
                $this->scripts=array();
                $this->metaTags=array();
                $this->linkTags=array();

                $this->recordCachingAction('clientScript','reset',array());
        }

        /**
         * Renders the registered scripts.
         * This method is called in {@link CController::render} when it finishes
         * rendering content. CClientScript thus gets a chance to insert script tags
         * at <code>head</code> and <code>body</code> sections in the HTML output.
         * @param string $output the existing output that needs to be inserted with script tags
         */
        public function render(&$output)
        {
                if(!$this->_hasScripts)
                        return;

                $this->renderCoreScripts();

                if(!empty($this->scriptMap))
                        $this->remapScripts();

                $this->unifyScripts();
                
////////////////////////////////////////////////////////////////////////////////
                // reorder the cssFiles
                if(!empty($this->cssFilesOrder))
                {
                        ksort($this->cssFilesOrder);
                    foreach($this->cssFilesOrder as $url)
                    {
                                $newCssFiles[$url]=$this->cssFiles[$url];
                        }
                    $this->cssFiles = $newCssFiles;
                }
                if(!empty($this->cssOrder))
                {
                        ksort($this->cssOrder);
                    foreach($this->cssOrder as $id)
                    {
                                $newCss[$id]=$this->css[$id];
                        }
                    $this->css = $newCss;
                }
                // reorder the scriptFiles
            if(!empty($this->scriptFilesOrder[self::POS_END]))
            {
                        ksort($this->scriptFilesOrder[self::POS_END]);
                    foreach($this->scriptFilesOrder[self::POS_END] as $url)
                    {
                                $newScriptFiles[$url]=$url;
                        }
                   $this->scriptFiles[self::POS_END] = $newScriptFiles;
            }

            if(!empty($this->scriptsOrder[self::POS_READY]))
            {
                        ksort($this->scriptsOrder[self::POS_READY]);
                    // reorder the css
                    foreach($this->scriptsOrder[self::POS_READY] as $id)
                    {
                                $newScript[$id]=$this->scripts[self::POS_READY][$id];
                        }

                   $this->scripts[self::POS_READY] = $newScript;
            }

////////////////////////////////////////////////////////////////////////////////

                $this->renderHead($output);
                if($this->enableJavaScript)
                {
                        $this->renderBodyBegin($output);
                        $this->renderBodyEnd($output);
                }
        }

        /**
         * Removes duplicated scripts from {@link scriptFiles}.
         * @since 1.1.5
         */
        protected function unifyScripts()
        {
                if(!$this->enableJavaScript)
                        return;
                $map=array();
                if(isset($this->scriptFiles[self::POS_HEAD]))
                        $map=$this->scriptFiles[self::POS_HEAD];

                if(isset($this->scriptFiles[self::POS_BEGIN]))
                {
                        foreach($this->scriptFiles[self::POS_BEGIN] as $key=>$scriptFile)
                        {
                                if(isset($map[$scriptFile]))
                                        unset($this->scriptFiles[self::POS_BEGIN][$key]);
                                else
                                        $map[$scriptFile]=true;
                        }
                }

                if(isset($this->scriptFiles[self::POS_END]))
                {
                        foreach($this->scriptFiles[self::POS_END] as $key=>$scriptFile)
                        {
                                if(isset($map[$scriptFile]))
                                        unset($this->scriptFiles[self::POS_END][$key]);
                        }
                }
        }

        /**
         * Uses {@link scriptMap} to re-map the registered scripts.
         * @since 1.0.3
         */
        protected function remapScripts()
        {
                $cssFiles=array();
                foreach($this->cssFiles as $url=>$media)
                {
                        $name=basename($url);
                        if(isset($this->scriptMap[$name]))
                        {
                                if($this->scriptMap[$name]!==false)
                                        $cssFiles[$this->scriptMap[$name]]=$media;
                        }
                        else if(isset($this->scriptMap['*.css']))
                        {
                                if($this->scriptMap['*.css']!==false)
                                        $cssFiles[$this->scriptMap['*.css']]=$media;
                        }
                        else
                                $cssFiles[$url]=$media;
                }
                $this->cssFiles=$cssFiles;

                $jsFiles=array();
                foreach($this->scriptFiles as $position=>$scripts)
                {
                        $jsFiles[$position]=array();
                        foreach($scripts as $key=>$script)
                        {
                                $name=basename($script);
                                if(isset($this->scriptMap[$name]))
                                {
                                        if($this->scriptMap[$name]!==false)
                                                $jsFiles[$position][$this->scriptMap[$name]]=$this->scriptMap[$name];
                                }
                                else if(isset($this->scriptMap['*.js']))
                                {
                                        if($this->scriptMap['*.js']!==false)
                                                $jsFiles[$position][$this->scriptMap['*.js']]=$this->scriptMap['*.js'];
                                }
                                else
                                        $jsFiles[$position][$key]=$script;
                        }
                }
                $this->scriptFiles=$jsFiles;
        }

        /**
         * Renders the specified core javascript library.
         * @since 1.0.3
         */
 public function renderCoreScripts()
{
    if($this->_coreScripts===null)
        return;
    $cssFiles=array();
    $jsFiles=array();
    foreach($this->_coreScripts as $name=>$package)
    {
        $baseUrl=$this->getCoreScriptUrl();
        if(!empty($package['js']))
        {
            foreach($package['js'] as $js)
                $jsFiles[$baseUrl.'/'.$js]=$baseUrl.'/'.$js;
        }
        if(!empty($package['css']))
        {
            foreach($package['css'] as $css)
                $cssFiles[$baseUrl.'/'.$css]='';
        }
    }
    // merge in place
    if($cssFiles!==array())
    {
        foreach($this->cssFiles as $cssFile=>$media)
            $cssFiles[$cssFile]=$media;
        $this->cssFiles=$cssFiles;
    }
    if($jsFiles!==array())
    {
        if(isset($this->scriptFiles[$this->coreScriptPosition]))
        {
            foreach($this->scriptFiles[$this->coreScriptPosition] as $url)
                $jsFiles[$url]=$url;
        }
        $this->scriptFiles[$this->coreScriptPosition]=$jsFiles;
    }
}

        /**
         * Inserts the scripts in the head section.
         * @param string $output the output to be inserted with scripts.
         */
        public function renderHead(&$output)
        {
                if ($this->combineCssFiles)
                        $this->combineCssFiles();

                if ($this->combineScriptFiles && $this->enableJavaScript)
                        $this->combineScriptFiles(self::POS_HEAD);

////////////////////////////////////////////////////////////////////////////////

                $html='';
                foreach($this->metaTags as $meta)
                        $html.=CHtml::metaTag($meta['content'],null,null,$meta)."\n";
                foreach($this->linkTags as $link)
                        $html.=CHtml::linkTag(null,null,null,null,$link)."\n";
                foreach($this->cssFiles as $url=>$media)
                        $html.=CHtml::cssFile($url,$media)."\n";
                foreach($this->css as $css)
                        $html.=CHtml::css($css[0],$css[1])."\n";
                if($this->enableJavaScript)
                {
                        if(isset($this->scriptFiles[self::POS_HEAD]))
                        {
                                foreach($this->scriptFiles[self::POS_HEAD] as $scriptFile)
                                        $html.=CHtml::scriptFile($scriptFile)."\n";
                        }

                        if(isset($this->scripts[self::POS_HEAD]))
                                $html.=CHtml::script(implode("\n",$this->scripts[self::POS_HEAD]))."\n";
                }

                if($html!=='')
                {
                        $count=0;
                        $output=preg_replace('/(<title\b[^>]*>|<\\/head\s*>)/is','<###head###>$1',$output,1,$count);
                        if($count)
                                $output=str_replace('<###head###>',$html,$output);
                        else
                                $output=$html.$output;
                }
        }

        /**
         * Inserts the scripts at the beginning of the body section.
         * @param string $output the output to be inserted with scripts.
         */
        public function renderBodyBegin(&$output)
        {
                // $this->enableJavascript has been checked in parent::render()
                if ($this->combineScriptFiles)
                        $this->combineScriptFiles(self::POS_BEGIN);
                        
                $html='';
                if(isset($this->scriptFiles[self::POS_BEGIN]))
                {
                        foreach($this->scriptFiles[self::POS_BEGIN] as $scriptFile)
                                $html.=CHtml::scriptFile($scriptFile)."\n";
                }
                if(isset($this->scripts[self::POS_BEGIN]))
                        $html.=CHtml::script(implode("\n",$this->scripts[self::POS_BEGIN]))."\n";

                if($html!=='')
                {
                        $count=0;
                        $output=preg_replace('/(<body\b[^>]*>)/is','$1<###begin###>',$output,1,$count);
                        if($count)
                                $output=str_replace('<###begin###>',$html,$output);
                        else
                                $output=$html.$output;
                }
        }

        /**
         * Inserts the scripts at the end of the body section.
         * @param string $output the output to be inserted with scripts.
         */
        public function renderBodyEnd(&$output)
        {
                // $this->enableJavascript has been checked in parent::render()
                if ($this->combineScriptFiles)
                        $this->combineScriptFiles(self::POS_END);
        
                if(!isset($this->scriptFiles[self::POS_END]) && !isset($this->scripts[self::POS_END])
                        && !isset($this->scripts[self::POS_READY]) && !isset($this->scripts[self::POS_LOAD]))
                        return;

                $fullPage=0;
                $output=preg_replace('/(<\\/body\s*>)/is','<###end###>$1',$output,1,$fullPage);
                $html='';
                if(isset($this->scriptFiles[self::POS_END]))
                {
                        foreach($this->scriptFiles[self::POS_END] as $scriptFile)
                                $html.=CHtml::scriptFile($scriptFile)."\n";
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
         * Returns the base URL of all core javascript files.
         * If the base URL is not explicitly set, this method will publish the whole directory
         * 'framework/web/js/source' and return the corresponding URL.
         * @return string the base URL of all core javascript files
         */
        public function getCoreScriptUrl()
        {
                if($this->_baseUrl!==null)
                        return $this->_baseUrl;
                else
                        return $this->_baseUrl=Yii::app()->getAssetManager()->publish(YII_PATH.'/web/js/source');
        }

        /**
         * Sets the base URL of all core javascript files.
         * This setter is provided in case when core javascript files are manually published
         * to a pre-specified location. This may save asset publishing time for large-scale applications.
         * @param string $value the base URL of all core javascript files.
         */
        public function setCoreScriptUrl($value)
        {
                $this->_baseUrl=$value;
        }

        /**
         * Registers a core javascript library.
         * @param string $name the core javascript library name
         * @return CClientScript the CClientScript object itself (to support method chaining, available since version 1.1.5).
         * @see renderCoreScript
         */
        public function registerCoreScript($name)
        {
                if(isset($this->_coreScripts[$name]))
                        return $this;

		if(isset($this->_packages[$name]))
        		$package=$this->_packages[$name];
    		else
    		{
        		if(!$this->_corePackages)
           			$this->_corePackages=require(YII_PATH.'/web/js/packages.php');
        			if(isset($this->_corePackages[$name]))
            				$package=$this->_corePackages[$name];
    			}

	
                /*if($this->_packages===null)
                {
                        $config=require(YII_PATH.'/web/js/packages.php');
                        $this->_packages=$config[0];
                        $this->_dependencies=$config[1];
*/

		if(isset($package))
	    	{
			if(!empty($package['depends']))
			{
		    		foreach($package['depends'] as $p)
		        		$this->registerCoreScript($p);
			}
			$this->_coreScripts[$name]=$package;
			$this->_hasScripts=true;
			$params=func_get_args();
			$this->recordCachingAction('clientScript','registerCoreScript',$params);
	    	}
 /*
                if(!isset($this->_packages[$name]))
                        return $this;
                if(isset($this->_dependencies[$name]))
                {
                        foreach($this->_dependencies[$name] as $depName)
                                $this->registerCoreScript($depName);
                }

                $this->_hasScripts=true;
                $this->_coreScripts[$name]=$name;
                $params=func_get_args();
                $this->recordCachingAction('clientScript','registerCoreScript',$params);
*/
                return $this;
        }

        /**
         * Registers a CSS file
         * @param string $url URL of the CSS file
         * @param string $media media that the CSS file should be applied to. If empty, it means all media types.
         * @return CClientScript the CClientScript object itself (to support method chaining, available since version 1.1.5).
         */
        public function registerCssFile($url,$media='',$order=0)
        {
                $this->_hasScripts=true;
                if($order==0) $order=100+count($this->cssFiles);
                $this->cssFilesOrder[$order]=$url;
                $this->cssFiles[$url]=$media;
                $params=func_get_args();
                $this->recordCachingAction('clientScript','registerCssFile',$params);
                return $this;
        }

        /**
         * Registers a piece of CSS code.
         * @param string $id ID that uniquely identifies this piece of CSS code
         * @param string $css the CSS code
         * @param string $media media that the CSS code should be applied to. If empty, it means all media types.
         * @return CClientScript the CClientScript object itself (to support method chaining, available since version 1.1.5).
         */
        public function registerCss($id,$css,$media='',$order=0)
        {
                $this->_hasScripts=true;
                if($order==0) $order=100+count($this->css);
                $this->cssOrder[$order]=$id;
                $this->css[$id]=array($css,$media);
                $params=func_get_args();
                $this->recordCachingAction('clientScript','registerCss',$params);
                return $this;
        }

        /**
         * Registers a javascript file.
         * @param string $url URL of the javascript file
         * @param integer $position the position of the JavaScript code. Valid values include the following:
         * <ul>
         * <li>CClientScript::POS_HEAD : the script is inserted in the head section right before the title element.</li>
         * <li>CClientScript::POS_BEGIN : the script is inserted at the beginning of the body section.</li>
         * <li>CClientScript::POS_END : the script is inserted at the end of the body section.</li>
         * </ul>
         * @return CClientScript the CClientScript object itself (to support method chaining, available since version 1.1.5).
         */
        //public function registerScriptFile($url,$position=self::POS_HEAD)
        public function registerScriptFile($url,$position=self::POS_END,$order=0)
        {

		//print_r($url);
                $this->_hasScripts=true;
                if($order==0) $order=100+(isset($this->scriptFiles[$position]) ? count($this->scriptFiles[$position]) : 0);
                $this->scriptFilesOrder[$position][$order]=$url;
                $this->scriptFiles[$position][$url]=$url;
                $params=func_get_args();
                $this->recordCachingAction('clientScript','registerScriptFile',$params);
                return $this;
        }

        /**
         * Registers a piece of javascript code.
         * @param string $id ID that uniquely identifies this piece of JavaScript code
         * @param string $script the javascript code
         * @param integer $position the position of the JavaScript code. Valid values include the following:
         * <ul>
         * <li>CClientScript::POS_HEAD : the script is inserted in the head section right before the title element.</li>
         * <li>CClientScript::POS_BEGIN : the script is inserted at the beginning of the body section.</li>
         * <li>CClientScript::POS_END : the script is inserted at the end of the body section.</li>
         * <li>CClientScript::POS_LOAD : the script is inserted in the window.onload() function.</li>
         * <li>CClientScript::POS_READY : the script is inserted in the jQuery's ready function.</li>
         * </ul>
         * @return CClientScript the CClientScript object itself (to support method chaining, available since version 1.1.5).
         */
        public function registerScript($id,$script,$position=self::POS_READY,$order=0)
        {
                $this->_hasScripts=true;
                if($order==0) $order=100+(isset($this->scripts[$position]) ? count($this->scripts[$position]) : 0);
                $this->scriptsOrder[$position][$order]=$id;
                $this->scripts[$position][$id]=$script;
                if($position===self::POS_READY || $position===self::POS_LOAD)
                        $this->registerCoreScript('jquery');
                $params=func_get_args();
                $this->recordCachingAction('clientScript','registerScript',$params);
                return $this;
        }

        /**
         * Registers a meta tag that will be inserted in the head section (right before the title element) of the resulting page.
         * @param string $content content attribute of the meta tag
         * @param string $name name attribute of the meta tag. If null, the attribute will not be generated
         * @param string $httpEquiv http-equiv attribute of the meta tag. If null, the attribute will not be generated
         * @param array $options other options in name-value pairs (e.g. 'scheme', 'lang')
         * @return CClientScript the CClientScript object itself (to support method chaining, available since version 1.1.5).
         * @since 1.0.1
         */
        public function registerMetaTag($content,$name=null,$httpEquiv=null,$options=array())
        {
                $this->_hasScripts=true;
                if($name!==null)
                        $options['name']=$name;
                if($httpEquiv!==null)
                        $options['http-equiv']=$httpEquiv;
                $options['content']=$content;
                $this->metaTags[serialize($options)]=$options;
                $params=func_get_args();
                $this->recordCachingAction('clientScript','registerMetaTag',$params);
                return $this;
        }

        /**
         * Registers a link tag that will be inserted in the head section (right before the title element) of the resulting page.
         * @param string $relation rel attribute of the link tag. If null, the attribute will not be generated.
         * @param string $type type attribute of the link tag. If null, the attribute will not be generated.
         * @param string $href href attribute of the link tag. If null, the attribute will not be generated.
         * @param string $media media attribute of the link tag. If null, the attribute will not be generated.
         * @param array $options other options in name-value pairs
         * @return CClientScript the CClientScript object itself (to support method chaining, available since version 1.1.5).
         * @since 1.0.1
         */
        public function registerLinkTag($relation=null,$type=null,$href=null,$media=null,$options=array())
        {
                $this->_hasScripts=true;
                if($relation!==null)
                        $options['rel']=$relation;
                if($type!==null)
                        $options['type']=$type;
                if($href!==null)
                        $options['href']=$href;
                if($media!==null)
                        $options['media']=$media;
                $this->linkTags[serialize($options)]=$options;
                $params=func_get_args();
                $this->recordCachingAction('clientScript','registerLinkTag',$params);
                return $this;
        }

        /**
         * Checks whether the CSS file has been registered.
         * @param string $url URL of the CSS file
         * @return boolean whether the CSS file is already registered
         */
        public function isCssFileRegistered($url)
        {
                return isset($this->cssFiles[$url]);
        }

        /**
         * Checks whether the CSS code has been registered.
         * @param string $id ID that uniquely identifies the CSS code
         * @return boolean whether the CSS code is already registered
         */
        public function isCssRegistered($id)
        {
                return isset($this->css[$id]);
        }

        /**
         * Checks whether the JavaScript file has been registered.
         * @param string $url URL of the javascript file
         * @param integer $position the position of the JavaScript code. Valid values include the following:
         * <ul>
         * <li>CClientScript::POS_HEAD : the script is inserted in the head section right before the title element.</li>
         * <li>CClientScript::POS_BEGIN : the script is inserted at the beginning of the body section.</li>
         * <li>CClientScript::POS_END : the script is inserted at the end of the body section.</li>
         * </ul>
         * @return boolean whether the javascript file is already registered
         */
        public function isScriptFileRegistered($url,$position=self::POS_HEAD)
        {
                return isset($this->scriptFiles[$position][$url]);
        }

        /**
         * Checks whether the JavaScript code has been registered.
         * @param string $id ID that uniquely identifies the JavaScript code
         * @param integer $position the position of the JavaScript code. Valid values include the following:
         * <ul>
         * <li>CClientScript::POS_HEAD : the script is inserted in the head section right before the title element.</li>
         * <li>CClientScript::POS_BEGIN : the script is inserted at the beginning of the body section.</li>
         * <li>CClientScript::POS_END : the script is inserted at the end of the body section.</li>
         * <li>CClientScript::POS_LOAD : the script is inserted in the window.onload() function.</li>
         * <li>CClientScript::POS_READY : the script is inserted in the jQuery's ready function.</li>
         * </ul>
         * @return boolean whether the javascript code is already registered
         */
        public function isScriptRegistered($id,$position=self::POS_READY)
        {
                return isset($this->scripts[$position][$id]);
        }

        /**
         * Records a method call when an output cache is in effect.
         * This is a shortcut to Yii::app()->controller->recordCachingAction.
         * In case when controller is absent, nothing is recorded.
         * @param string $context a property name of the controller. It refers to an object
         * whose method is being called. If empty it means the controller itself.
         * @param string $method the method name
         * @param array $params parameters passed to the method
         * @see COutputCache
         * @since 1.0.5
         */
        protected function recordCachingAction($context,$method,$params)
        {
                if(($controller=Yii::app()->getController())!==null)
                        $controller->recordCachingAction($context,$method,$params);
        }

/**/

        /**
         * Combine the CSS files, if cached enabled then cache the result so we won't have to do that
         * Every time
         */
        protected function combineCssFiles()
        {
                // Check the need for combination
                if (count($this->cssFiles) < 2)
                        return;

                $cssFiles = array();
                $toBeCombined = array();

                foreach ($this->cssFiles as $url => $media)
                {
                        $file = $this->getLocalPath($url);
                        if ($file === false)
                                $cssFiles[$url] = $media;
                        else
                        {
                                $media = strtolower($media);
                                if ($media === '')
                                        $media = 'all';
                                if (!isset($toBeCombined[$media]))
                                        $toBeCombined[$media] = array();
                                $toBeCombined[$media][$url] = $file;
                        }
                }

                foreach ($toBeCombined as $media => $files)
                {
                        if ($media === 'all')
                                $media = '';

                        if (count($files) === 1)
                                $url = key($files);
                        else
                        {
                                // get unique combined filename
                                $fname = $this->getCombinedFileName($this->cssFileName, $files, $media);
                                $fpath = Yii::app()->assetManager->basePath . DIRECTORY_SEPARATOR . $fname;
                                // check exists file
                                if ($valid = file_exists($fpath))
                                {
                                        $mtime = filemtime($fpath);
                                        foreach ($files as $file)
                                        {
                                                if ($mtime < filemtime($file))
                                                {
                                                        $valid = false;
                                                        break;
                                                }
                                        }
                                }
                                // re-generate the file
                                if (!$valid)
                                {
                                        $urlRegex = '#url\s*\(\s*([\'"])?(?!/|http://)([^\'"\s])#i';
                                        $fileBuffer = '';
                                        foreach ($files as $url => $file)
                                        {
                                                $contents = file_get_contents($file);
                                                if ($contents)
                                                {
                                                        // Reset relative url() in css file
                                                        if (preg_match($urlRegex, $contents))
                                                        {
                                                                $reurl = $this->getRelativeUrl(Yii::app()->assetManager->baseUrl, dirname($url));
                                                                $contents = preg_replace($urlRegex, 'url(${1}' . $reurl . '/${2}', $contents);
                                                        }
                                                        // Append the contents to the fileBuffer
                                                        $fileBuffer .= "/*** CSS File: {$url}";
                                                        if ($this->optimizeCssFiles 
                                                                && strpos($file, '.min.') === false && strpos($file, '.pack.') === false)
                                                        {
                                                                $fileBuffer .= ", Original size: " . number_format(strlen($contents)) . ", Compressed size: ";
                                                                $contents = $this->optimizeCssCode($contents);
                                                                $fileBuffer .= number_format(strlen($contents));
                                                        }
                                                        $fileBuffer .= " ***/\n";
                                                        $fileBuffer .= $contents . "\n\n";
                                                }
                                        }
                                        file_put_contents($fpath, $fileBuffer);
                                }
                                // real url of combined file
                                $url = Yii::app()->assetManager->baseUrl . '/' . $fname . '?' . filemtime($fpath);
                        }
                        $cssFiles[$url] = $media;
                }
                // use new cssFiles list replace old ones
                $this->cssFiles = $cssFiles;
        }

        /**
         * Combine script files, we combine them based on their position, each is combined in a separate file
         * to load the required data in the required location.
         * @param $type CClientScript the type of script files currently combined
         */
        protected function combineScriptFiles($type = self::POS_HEAD)
        {
                // Check the need for combination
                if (!isset($this->scriptFiles[$type]) || count($this->scriptFiles[$type]) < 2)
                        return;

                $scriptFiles = array();
                $toBeCombined = array();

                foreach ($this->scriptFiles[$type] as $url)
                {
                        $file = $this->getLocalPath($url);
                        if ($file === false)
                                $scriptFiles[$url] = $url;
                        else
                                $toBeCombined[$url] = $file;
                }

                if (count($toBeCombined) === 1)
                {
                        $url = key($toBeCombined);
                        $scriptFiles[$url] = $url;
                }
                else if (count($toBeCombined) > 1)
                {
                        // get unique combined filename
                        $fname = $this->getCombinedFileName($this->scriptFileName, array_values($toBeCombined), $type);
                        $fpath = Yii::app()->assetManager->basePath . DIRECTORY_SEPARATOR . $fname;
                        // check exists file
                        if ($valid = file_exists($fpath))
                        {
                                $mtime = filemtime($fpath);
                                foreach ($toBeCombined as $file)
                                {
                                        if ($mtime < filemtime($file))
                                        {
                                                $valid = false;
                                                break;
                                        }
                                }
                        }
                        // re-generate the file
                        if (!$valid)
                        {
                                $fileBuffer = '';
                                foreach ($toBeCombined as $url => $file)
                                {
                                        $contents = file_get_contents($file);
                                        if ($contents)
                                        {
                                                // Append the contents to the fileBuffer
                                                $fileBuffer .= "/*** Script File: {$url}";
                                                if ($this->optimizeScriptFiles
                                                        && strpos($file, '.min.') === false && strpos($file, '.pack.') === false)
                                                {
                                                        $fileBuffer .= ", Original size: " . number_format(strlen($contents)) . ", Compressed size: ";
                                                        $contents = $this->optimizeScriptCode($contents);
                                                        $fileBuffer .= number_format(strlen($contents));
                                                }
						if (!preg_match('~;$~', trim($contents))) $contents = $contents . ";\n";
                                                $fileBuffer .= " ***/\n";
                                                $fileBuffer .= $contents . "\n\n";
                                        }
                                }
                                file_put_contents($fpath, $fileBuffer);
                        }
                        // add the combined file into scriptFiles
                        $url = Yii::app()->assetManager->baseUrl . '/' . $fname . '?' . filemtime($fpath);;
                        $scriptFiles[$url] = $url;
                }
                // use new scriptFiles list replace old ones
                $this->scriptFiles[$type] = $scriptFiles;
        }

        /**
         * Get realpath of published file via its url, refer to {link: CAssetManager}
         * @return string local file path for this script or css url
         */
        private function getLocalPath($url)
        {
                $basePath = dirname(Yii::app()->request->scriptFile) . DIRECTORY_SEPARATOR;
                $baseUrl = Yii::app()->request->baseUrl . '/';
                if (!strncmp($url, $baseUrl, strlen($baseUrl)))
                {
                        $url = $basePath . substr($url, strlen($baseUrl));
                        return $url;
                }
                return false;
        }

        /**
         * Calculate the relative url
         * @param string $from source url, begin with slash and not end width slash.
         * @param string $to dest url
         * @return string result relative url
         */
        private function getRelativeUrl($from, $to)
        {
                $relative = '';
                while (true)
                {
                        if ($from === $to)
                                return $relative;
                        else if ($from === dirname($from))
                                return $relative . substr($to, 1);
                        if (!strncmp($from . '/', $to, strlen($from) + 1))
                                return $relative . substr($to, strlen($from) + 1);

                        $from = dirname($from);
                        $relative .= '../';
                }
        }

        /**
         * Get unique filename for combined files
         * @param string $name default filename
         * @param array $files files to be combined
         * @param string $type css media or script position
         * @return string unique filename
         */
        private function getCombinedFileName($name, $files, $type = '')
        {
                $pos = strrpos($name, '.');
                if (!$pos)
                        $pos = strlen($pos);
                $hash = sprintf('%x', crc32(implode('+', $files)));

                $ret = substr($name, 0, $pos);
                if ($type !== '')
                        $ret .= '-' . $type;
                $ret .= '-' . $hash . substr($name, $pos);

                return $ret;
        }

        /**
         * Optmize css, strip any spaces and newline
         * @param string $data input css data
         * @return string optmized css data
         */
        private function optimizeCssCode($code)
        {
                require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'CssMin.php';
                return CssMin::minify($code, array('compress-unit-values' => true));
        }

        /**
         * Optimize script via google compiler
         * @param string $data script code
         * @return string optimized script code
         */
        private function optimizeScriptCode($code)
        {
                require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'JSMinPlus.php';
                $minified = JSMinPlus::minify($code);
                return ($minified === false ? $code : $minified);
        }
}
