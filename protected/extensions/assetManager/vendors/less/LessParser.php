<?php
/**
 * LessCompiler class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::setPathOfAlias('Less', dirname(__FILE__).'/lessphp/lib/Less');

/**
 * Less compiler application component.
 * Preload the component to enable auto compiling.
 */
class LessParser
{
	/**
	 * @var string the base path.
	 */
	public $basePath;
	/**
	 * @var array the paths for the files to parse.
	 */
	public $paths = array();
	/**
	 * @var boolean indicates whether to force compiling.
	 */
	public $forceCompile = false;
	/**
	 * @var boolean compiler debug mode.
	 */
	public $debug = false;
	/**
	 * @var boolean whether to compress css or not.
	 */
	public $compress = false;

	protected $_parser;

	/**
	 * Initializes the component.
	 */
	public function __construct()
	{
		if ($this->basePath === null)
			$this->basePath = Yii::getPathOfAlias('webroot');

		if (!file_exists($this->basePath))
			throw new CException(__CLASS__.': Failed to initialize compiler. Base path does not exist.');

		$env = new \Less\Environment();
		$env->setDebug($this->debug);
		$env->setCompress($this->compress);
		$this->_parser = new \Less\Parser($env);

		if ($this->forceCompile || $this->hasChanges())
			$this->compile();
	}

	/**
	 * Compiles the less files.
	 * @throws CException if the source path does not exist
	 */
	public function compile()
	{
		foreach ($this->paths as $lessPath => $cssPath)
		{
			$fromPath = $this->basePath.'/'.$lessPath;
			$toPath = $this->basePath.'/'.$cssPath;

			if (file_exists($fromPath))
				file_put_contents($toPath, $this->parse($fromPath));
			else
				throw new CException(__CLASS__.': Failed to compile less file. Source path does not exist.');

			$this->_parser->clearCss();
		}
	}

	/**
	 * Parses the less code to CSS.
	 * @param string $filename the file path to the less file
	 * @return string the CSS
	 */
	public function parse($filename)
	{
		try
		{
			$css = $this->_parser->parseFile($filename);
		}
		catch (\Less\Exception\ParserException $e)
		{
			throw new CException(__CLASS__.': Failed to parse less file. "'.$e->getMessage().'".');
		}

		return $css;
	}

	/**
	 * Returns whether any of files configured to be compiled has changed.
	 * @return boolean the result
	 */
	protected function hasChanges()
	{
		$dirs = array();
		foreach ($this->paths as $source => $destination)
		{
			$destination = realpath($destination);
			$compiled = $this->getLastModified($destination);
			if (!isset($lastCompiled) || $compiled < $lastCompiled )
				$lastCompiled = $compiled;

			$source = realpath($source);
			if (!in_array($source, $dirs))
				$dirs[] = $source;
		}

		foreach ($dirs as $dir) {
			$modified = $this->getLastModified($dir);
			if (!isset($lastModified) || $modified < $lastModified)
				$lastModified = $modified;
		}

		return isset($lastCompiled) && isset($lastModified) && $lastModified > $lastCompiled;
	}

	/**
	 * Returns the last modified for a specific path.
	 * @param string $path the path
	 * @return integer the last modified (as a timestamp)
	 */
	protected function getLastModified($path)
	{
		if (!file_exists($path))
			return 0;
		else
		{
			if (is_file($path))
			{
				$stat = stat($path);
				return $stat['mtime'];
			}
			else
			{
				$lastModified = null;

				$dir = dir($path);
				while ($entry = $dir->read())
				{
					if (strpos($entry, '.') === 0)
						continue;

					$entry = $path.'/'.$entry;

					if( is_dir($entry) )
						$modified = $this->getLastModified($entry);
					else
					{
						$stat = stat($entry);
						$modified = $stat['mtime'];
					}

					if( isset($lastModified) || $modified > $lastModified )
						$lastModified = $modified;
				}

				return $lastModified;
			}
		}
	}
}
