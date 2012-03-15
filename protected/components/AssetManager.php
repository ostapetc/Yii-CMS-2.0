<?php
/**
 * init version
 * PBMAssetManager class file.
 * @author		Chris Yates <chris.l.yates@gmail.com>
 * @copyright	Copyright &copy; 2010 PBM Web Development
 * @license		http://assetManager.googlecode.com/files/license.txt
 * @package		PBM
 */

/**
 * rewrite version
 */
/**
 * PBMAssetManager class.
 * PBMAssetManager overrides CAssetManager::publish to provide parsing of assets
 * when required.
 *
 * Configuration
 * -------------
 * Import the component.
 * Yii::import('path.to.component.PBMAssetManager');
 *
 * Declare the use of this component as the asset manager component. This
 * example declares a Sass {@link } parser; multiple parsers may be declared.
 * <pre>
 * // application components
 * 'components'=>array(
 *   'assetManager' => array(
 *     'class' => 'PBMAssetManager',
 *     'parsers' => array(
 *       'sass' => array( // key == the type of file to parse
 *         'class' => 'ext.haml.Sass', // path alias to the parser
 *         'output' => 'css', // the file type it is parsed to
 *         'options' => array(<Parser specific options>)
 *       ),
 *     )
 *   )
 * )
 * </pre>
 *
 * You can also declare the "force" parameter to be true. This forces assets to
 * be published whether newer than the published asset or not; this is for
 * development so that changes to deep files get published without having to
 * flush the asset directory. Make sure this parameter is removed or declared
 * false in production.
 *
 * Usage
 * -----
 * Usage is exactly the same as publishing an asset with CAssetManager, i.e.
 *
 * $publishedAsset = Yii::app()->getAssetMananger()->publish(Yii::getPathOfAlias('allias.to.asset.directory'). DIRECTORY_SEPARATOR . 'asset.sass');
 *
 * The only difference is that parsing of files will take place during the
 * publish. Files that do not require parsing are handled exactly as before.
 * 
 */
class AssetManager extends CAssetManager {
	/**
	 * @var array asset parsers
	 */
	public $parsers;
	/**
	 * @var boolean if true the asset will always be published
	 */
	public $force = false;
	/**
	 * @var string base web accessible path for storing private files
	 */
	private $_basePath;
	/**
	 * @var string base URL for accessing the publishing directory.
	 */
	private $_baseUrl;
	/**
	 * @var array published assets
	 */
	private $_published=array();


	public function publish($path,$hashByName=false,$level=-1,$forceCopy=false)
    {
		if(isset($this->_published[$path]))
        {
			return $this->_published[$path];
		}
		else if(($src=realpath($path))!==false)
        {
			if(is_file($src))
            {
				$dir=$this->hash($hashByName ? basename($src) : dirname($src));
				$fileName=basename($src);
				$suffix=substr(strrchr($fileName, '.'), 1);
				$dstDir=$this->getBasePath().DIRECTORY_SEPARATOR.$dir;

				if (array_key_exists($suffix, $this->parsers))
                {
					$fileName=basename($src, $suffix).$this->parsers[$suffix]['output'];
				}
				$dstFile=$dstDir.DIRECTORY_SEPARATOR.$fileName;

				if($this->force || @filemtime($dstFile)<@filemtime($src))
                {
					if(!is_dir($dstDir))
                    {
						mkdir($dstDir);
						@chmod($dstDir,0777);
					}

					if (array_key_exists($suffix, $this->parsers))
                    {
						$parserClass = Yii::import($this->parsers[$suffix]['class']);
						$parser = new $parserClass($this->parsers[$suffix]['options']);
						file_put_contents($dstFile, $parser->parse($src));
					}
					else
                    {
						copy($src,$dstFile);
					}
				}

				return $this->_published[$path]=$this->getBaseUrl()."/$dir/$fileName";
			}
			else if(is_dir($src))
            {
				$dir=$this->hash($hashByName ? basename($src) : $src);
				$dstDir=$this->getBasePath().DIRECTORY_SEPARATOR.$dir;

                if($this->linkAssets)
                {
                    if(!is_dir($dstDir))
                    symlink($src,$dstDir);
                }
                else if(!is_dir($dstDir) || $forceCopy)
                {
					CFileHelper::copyDirectory($src,$dstDir,array(
                        'exclude'=>$this->excludeFiles,
                        'level'=>$level,
                        'newDirMode'=>$this->newDirMode,
                        'newFileMode'=>$this->newFileMode
                    ));
				}
				return $this->_published[$path]=$this->getBaseUrl().'/'.$dir;
			}
		}
		throw new CException(Yii::t('yii','The asset "{asset}" to be published does not exist.',
			array('{asset}'=>$path)));
	}

}
