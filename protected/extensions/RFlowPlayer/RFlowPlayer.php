
<?php

class RFlowPlayer extends CWidget
{

	public $flv;
	public $swfUrl;
	
	public $options = array();
	public $htmlOptions = array();
	
	private $_defOptions  = array(
//		'plugins'=> array(
//			'controls'=> null,
//		),
		'clip' => array(
			'autoPlay' => true,
		),
	);
	
	private $js = array(
		'flowplayer-3.2.6.min.js'
	);
	private $css = array(
		'eflowplayer.css',
	);
	private $assets;

	private function publishAssets()
	{
		$assets = dirname(__FILE__) . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR;
		$this->assets = Yii::app()->getAssetManager()->publish($assets);
	}

	private function registerScripts()
	{
		$cs = Yii::app()->clientScript;

		foreach($this->js as $file)
		{
			$cs->registerScriptFile($this->assets . "/" . $file, CClientScript::POS_END);
		}
		foreach($this->css as $file)
		{
			$cs->registerCssFile($this->assets . "/" . $file);
		}
	}

	public function init()
	{
		$this->options = CMap::mergeArray($this->_defOptions, $this->options);
		$this->publishAssets();
		$this->registerScripts();

		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $this->id;
		if(!isset($this->swfUrl))
			$this->swfUrl = $this->assets . "/flowplayer-3.2.7.swf";
	}

	public function run()
	{
		$this->renderContainer();
		$this->flowplayerScript();
	}
	private function renderContainer()
	{
		echo CHtml::link('', $this->flv, $this->htmlOptions);
	}
	private function flowplayerScript($flv = null)
	{
		$options = CJavaScript::encode($this->options);
		
		Yii::app()->clientScript->registerScript($this->htmlOptions['id'], "flowplayer('" . $this->htmlOptions['id'] . "','" . $this->swfUrl . "', " . $options . ")", CClientScript::POS_READY
		);
	}
}