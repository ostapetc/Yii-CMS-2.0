<?php

/*
 * Yii Debug Toolbar
 *
 * Using:
 * 1. First Step.
 * Extract yiidebugtb folder to [webroot]/protected/extensions/yiidebugtb
 * --Test:
 * -- You must have an "[webroot]/protected/extensions/yiidebugtb/XWebDebugRouter.php" file
 * -- if you all right way.
 *
 * 2. Second Step.
 * Open [webroot]/protected/config/main.php, find section 'import' and add following lines which belongs to yiidebugtb:
 *
 * [...]
 * // autoloading model and component classes
 * 'import'=>array(
 * 		'application.models.*',
 * 		'application.extensions.yiidebugtb.*'
 * 		[...]
 * ),
 * [...]
 *
 * 3. And Last Step.
 * In [webroot]/protected/config/main.php find section 'routes' and add following lines for XWebDebugRouter:
 *
 * [...]
 * 'routes'=>array(
 * 		array(
 * 			'class'=>'XWebDebugRouter',
 * 			'config'=>'alignLeft, opaque, runInDebug, fixedPos, collapsed',
 * 			'levels'=>'error, warning, trace, profile, info',
 *      'allowedIPs'=>array('127.0.0.1','192.168.1.54','192\.168\.1[0-5]\.[0-9]{3}'),
 * 		),
 * ),
 * [...]
 *
 * Config options are mean:
 * 'alignLeft'	=> Debug toolbar will be aligned to the top left corner of browser window
 * 'opaque'		=> Makes debug toolbar almost invisible when it's minimized
 * 'runInDebug'	=> Show debug toolbar only if Yii application running in DEBUG MODE (see index.php for details)
 * 'fixedPos'	=> Makes debug toolbar sticky with browser window, not document!
 * 'collapsed'	=> Show debug toolbar minimized by default.
 *
 * Also there is an additional security feature you may need - 'allowedIPs' option. This option
 * holds the array of IP addresses of all machines you need to use in development cycle. So if you
 * forget to remove YII_DEBUG from bootstrap file for the production stage, your client don't see
 * the toolbar anyway.
 * AllowedIPs be defined as a preg regexps ie: '192\.168\.1[0-5]\.[0-9]{3}'
 */

/**
 * Helper class for array dumping.
 */
class arrayDumper
{

	private static $_objects;
	private static $_output;
	private static $_depth;

	/**
	 * Displays a variable.
	 * This method achieves the similar functionality as var_dump and print_r
	 * but is more robust when handling complex objects such as Yii controllers.
	 * @param mixed variable to be dumped
	 * @param integer maximum depth that the dumper should go into the variable. Defaults to 10.
	 * @param boolean whether the result should be syntax-highlighted
	 */
	public static function dump($var,$depth=10,$highlight=false, $yamlStyle = false)
	{
		return $yamlStyle == false ? CVarDumper::dumpAsString($var, $depth, $highlight) : self::dumpAsString($var,$depth,$highlight);
	}

	/**
	 * Dumps a variable in terms of a string.
	 * This method achieves the similar functionality as var_dump and print_r
	 * but is more robust when handling complex objects such as Yii controllers.
	 * @param mixed variable to be dumped
	 * @param integer maximum depth that the dumper should go into the variable. Defaults to 10.
	 * @param boolean whether the result should be syntax-highlighted
	 * @return string the string representation of the variable
	 */
	public static function dumpAsString($var,$depth=10,$highlight=false)
	{
		self::$_output='';
		self::$_objects=array();
		self::$_depth=$depth;
		self::dumpInternal($var,0);
		if($highlight)
		{
			$result=highlight_string("<?php\n".self::$_output,true);
			self::$_output=preg_replace('/&lt;\\?php<br \\/>/','',$result,1);
		}
		return self::$_output;
	}

	private static function dumpInternal($var,$level)
	{
		switch(gettype($var))
		{
			case 'boolean':
				self::$_output.=$var?'true':'false';
				break;
			case 'integer':
				self::$_output.="$var";
				break;
			case 'double':
				self::$_output.="$var";
				break;
			case 'string':
				self::$_output.="'$var'";
				break;
			case 'resource':
				self::$_output.='{resource}';
				break;
			case 'NULL':
				self::$_output.="null";
				break;
			case 'unknown type':
				self::$_output.='{unknown}';
				break;
			case 'array':
				if(self::$_depth<=$level)
					self::$_output.='array(...)';
				else if(empty($var))
					self::$_output.='{ }';
				else
				{
					$keys=array_keys($var);
					$spaces=str_repeat(' ',$level*2);
					self::$_output.=$spaces.'';
					foreach($keys as $key)
					{
						self::$_output.=($level == 0 ? '' : "\n").$spaces."  $key: ";
						self::$_output.=self::dumpInternal($var[$key],$level+1);
						self::$_output.=($level == 0 ? "\n" : '');
					}
					self::$_output.="";
				}
				break;
			case 'object':
				if(($id=array_search($var,self::$_objects,true))!==false)
					self::$_output.=get_class($var).'#'.($id+1).'(...)';
				else if(self::$_depth<=$level)
					self::$_output.=get_class($var).'(...)';
				else
				{
					$id=array_push(self::$_objects,$var);
					$className=get_class($var);
					$members=(array)$var;
					$keys=array_keys($members);
					$spaces=str_repeat(' ',$level*2);
					self::$_output.="$className ID:#$id";//\n".$spaces.'(';
					foreach($keys as $key)
					{
						$keyDisplay=strtr(trim($key),array("\0"=>'->'));
						self::$_output.="\n".$spaces."  $keyDisplay: ";
						self::$_output.=self::dumpInternal($members[$key],$level+1);
					}
					self::$_output.="\n".$spaces.')';
				}
				break;
				default:
					 self::$_output.="\n".$spaces.'~'.$var;
		}
	}
}

/**
 * Render debug panel to document using view and configuration parameters
 */
class yiiDebugPanel
{
	public function render($items = array(), $config = array())
	{
		$msg = "Run rendering...\n";
		$alignLeft = isset($config['alignLeft']) ? true : false;
		$opaque = isset($config['opaque']) ? true : false;;
		$fixedPos = isset($config['fixedPos']) ? true : false;
		$collapsed = isset($config['collapsed']) ? true : false;;

		$viewFile=dirname(__FILE__).DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'debugPanel.php';
		include(Yii::app()->findLocalizedFile($viewFile,'en'));
	}
}

/**
 * Parent class for the classes may be used on DebugPanel.
 * It have basic grid render and configuration functionality .
 */
class yiiDebugClass
{
	protected static $_config = array();

	public static function timestampToTime($timestamp)
	{
		return date('H:i:s.',$timestamp).(int)(($timestamp-(int)$timestamp)*1000000);
	}

	public static function render($items)
	{
		$result = '';
		$odd = true;
		foreach ($items as $item)
		{
			list($message, $level, $category, $timestamp) = $item;
			$message = CHtml::encode($message);
			// put each source file on its own line
			$message = implode("<br/>", explode("\n", $message));
			$time=yiiDebugTrace::timestampToTime($timestamp);
			$odd = !$odd;

			$result .= '<tr'.($odd ? ' class="odd"' : '').'><td>'.$time.'</td><td>'.$level.'</td><td>'.$category.'</td><td>'.$message.'</td></tr>';
		}

		if ($result !== '') $result = '<tbody>'.$result.'</tbody>';

		$result = '<table><thead><tr><th>Time</th><th>Level</th><th>Category</th><th width="100%">Message</th></tr></thead>'.$result.'</table>';

		return $result;
	}

	public static function getInfo($data, $config = null)
	{
		if (!is_null($config))
		{
			self::$_config = $config;
		}
	}
}

class yiiDebugDB extends yiiDebugClass
{
	public static function getInfo($data, $config = null)
	{
		parent::getInfo($data);
		$result = array();
		$result['panelTitle'] = 'Database Queries';
		$count = 0;
		$items = array();
		foreach ($data as $row)
		{
			if (substr($row[2],0,9) == 'system.db')
			{
				$items[] = $row;
				if ($row[2] == 'system.db.CDbCommand') $count++;
			}
		}

		if (count($items) > 0) $result['content'] = yiiDebugTrace::render($items);

		$result['title'] = 'DB Query: '.$count;

		return $result;
	}
}

class yiiDebugTrace extends yiiDebugClass
{
	public static function getInfo($data, $config = null)
	{
		parent::getInfo($data);
		$result = array();
		$result['title'] = 'App Log';
		$result['panelTitle'] = 'Application Log';
		$items = array();
		foreach ($data as $row)
		{
			if (substr($row[2],0,9) != 'system.db')
			$items[] = $row;
		}

		if (count($items) > 0) $result['content'] = yiiDebugTrace::render($items);

		return $result;
	}
}

class yiiDebugTime extends yiiDebugClass
{
	public static function getInfo($data, $config = null)
	{
		parent::getInfo($data);
		$result = array();
		$result['title'] = 'Time: '.(round(Yii::getLogger()->getExecutionTime(),3));

		return $result;
	}
}

class yiiDebugMem extends yiiDebugClass
{
	public static function getInfo($data, $config = null)
	{
		parent::getInfo($data);
		$result = array();
		//round it for two digits after point
		$result['title'] = 'Memory: '.(round(Yii::getLogger()->getMemoryUsage() / 1024, 2)).'Kb';

		return $result;
	}
}

class yiiDebugConfig extends yiiDebugClass
{
	public static $yamlStyle = false;

	public static function getHeadInfo()
	{
		$result = '';

		$config = array(
			'debug'			=> (DEFINED('YII_DEBUG') && YII_DEBUG != false) ? 'on' : 'off',
			'xdebug'		=> extension_loaded('xdebug') ? 'on' : 'off',
			'tokenizer'		=> function_exists('token_get_all') ? 'on' : 'off',
			'eaccelerator'	=> extension_loaded('eaccelerator') && ini_get('eaccelerator.enable') ? 'on' : 'off',
			'apc'			=> extension_loaded('apc') && ini_get('apc.enabled') ? 'on' : 'off',
			'xcache'		=> extension_loaded('xcache') && ini_get('xcache.cacher') ? 'on' : 'off',
		);

		$result = '<ul class="yiiDebugInfoInline">';
		foreach ($config as $key => $value)
		{
			$result .= '<li class="is'.$value.'">'.$key.'</li>';
		}
		$result .= '</ul>';

		return $result;
	}

	public static function sessionAsArray()
	{
		if (isset($_SESSION))
		{
			$phpSession = array();
			$sessKeyLen = null;
			foreach ($_SESSION as $key=>$value)
			{
				if (is_null($sessKeyLen))
				{
					$values['PHP']['Key'] = substr($key, 1, strpos($key, '_')-1);
					$sessKeyLen = strlen($values['PHP']['Key'])+2;
				}
				$phpSession[substr($key, $sessKeyLen)] = $value;
			}
			$values['PHP']['Data'] = $phpSession;
		}
		if (isset($_COOKIE)) $values['Cookie'] = $_COOKIE;
		$values['Yii'] = Yii::app()->session;
		return $values;
	}

	public static function globalsAsArray()
	{
		$values = array();
		foreach (array('server', 'files', 'env') as $name)
		{
			if (!isset($GLOBALS['_'.strtoupper($name)])) continue;

			$values[$name] = array();
			foreach ($GLOBALS['_'.strtoupper($name)] as $key => $value)
			{
				$values[$name][$key] = $value;
			}
			ksort($values[$name]);
		}

		ksort($values);

		return $values;
	}

	public static function phpInfoAsArray()
	{
		$values = array(
			'php'			=> phpversion(),
			'os'			=> php_uname(),
			'extensions'	=> get_loaded_extensions(),
		);

		// assign extension version
		if ($values['extensions'])
		{
			foreach($values['extensions'] as $key => $extension)
			{
				$values['extensions'][$key] = phpversion($extension) ? sprintf('%s (%s)', $extension, phpversion($extension)) : $extension;
			}
		}

		return $values;
	}

	public static function requestAsArray()
	{
		$values = array();
		if (isset($_GET)) $values['Get'] = $_GET;
		if (isset($_POST)) $values['Post'] = $_POST;
		$values['Yii'] = Yii::app()->request;
		return $values;
	}

	public static function yiiAppAsArray()
	{
		$result = Yii::app();
		return Yii::app();
	}

	protected static function formatArrayAsHtml($id, $values, $highlight = false)
	{
		$id = ucfirst(strtolower($id));

		return '
		<div style="text-align: left" class="yiiDebugInfoList">
		<h2> <a href="#" onclick="yiiWebDebugToggleVisible(\'yiiWDCFG'.$id.'\'); return false;">+</a>'.$id.'</h2>'.
		//'<div id="yiiWDCFG'.$id.'" style="display: none;"><pre>' .($formatted ? $values : arrayDumper::dump(arrayDumper::removeObjects($values),$highlight)) . '</pre></div></div>';
		'<div id="yiiWDCFG'.$id.'" style="display: none;"><pre>' .arrayDumper::dump($values, 10, $highlight, isset(self::$_config['yamlStyle'])) . '</pre></div></div>';
	}

	public static function getInfo($data, $config = null)
	{
		parent::getInfo($data, $config);
		$result = array();
		$result['title'] = 'Yii ver: '.(Yii::getVersion());
		$result['headinfo'] = self::getHeadInfo();
		$result['panelTitle'] = 'Configuration';
		$result['content'] = self::formatArrayAsHtml('globals', self::globalsAsArray(),true);
		$result['content'] .= self::formatArrayAsHtml('session', self::sessionAsArray(), true);
		$result['content'] .= self::formatArrayAsHtml('php', self::phpInfoAsArray(), true);
		$result['content'] .= self::formatArrayAsHtml('request', self::requestAsArray(), true);
		$result['content'] .= self::formatArrayAsHtml('Yii::app()', self::YiiAppAsArray() , true);
		$result['content'] .= self::formatArrayAsHtml('WebdebugToolbar', self::$_config, true);

		return $result;
	}
}

/**
 * Main class for using inside an Yii application
 *
 * It processes the logs of running instance of application
 * and renders self output to the end of server output (after </html> tag of document).
 */
class XWebDebugRouter extends CLogRoute
{
	public $config = '';
	public $allowedIPs = array('127.0.0.1');

	public function collectLogs($logger, $processLogs = false)
	{
		$logs=$logger->getLogs($this->levels,$this->categories);
		if(empty($logs)) $logs = array();
		$this->processLogs($logs);
	}

	public function processLogs($logs)
	{
		$app=Yii::app();
		$config = array();

		$ip = $app->request->getUserHostAddress();
		$allowed = false;
		foreach($this->allowedIPs as $pattern)
		{
			// if found any char other than [0-9] and dot, treat pattern as a regexp
			if(preg_match('/[^0-9:\.]/', $pattern))
			{
				if(preg_match('/'.$pattern.'/', $ip))
				{
					$allowed = true;
					break;
				}

			}
			else if($pattern === $ip)
			{
				$allowed = true;
				break;
			}
		}

		if(!$allowed) return;

		foreach (explode(',', $this->config) as $value)
		{
			$value = trim($value);
			$config[$value] = true;
		}

		//Checking for an AJAX Requests
		if(!($app instanceof CWebApplication) || $app->getRequest()->getIsAjaxRequest()) return;

		//Checking for an DEBUG mode of running app
		if (isset($config['runInDebug']) && (!DEFINED('YII_DEBUG') || YII_DEBUG == false)) return;

		$items = array();

		$items[] = yiiDebugConfig::getInfo($logs, $config);
		$items[] = yiiDebugMem::getInfo($logs);
		$items[] = yiiDebugTime::getInfo($logs);
		$items[] = yiiDebugDB::getInfo($logs);
		$items[] = yiiDebugTrace::getInfo($logs);

		$panel = new yiiDebugPanel();
		$panel->render($items, $config);
	}
}
