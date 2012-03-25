<?
$cs=Yii::app()->clientScript;
$cs->scriptMap=array();
$baseUrl=$this->module->assetsUrl;
$cs->registerCoreScript('jquery');
$cs->registerScriptFile($baseUrl.'/js/tools.tooltip-1.1.3.min.js');
$cs->registerScriptFile($baseUrl.'/js/fancybox/jquery.fancybox-1.3.1.pack.js');
$cs->registerCssFile($baseUrl.'/js/fancybox/jquery.fancybox-1.3.1.css');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<? echo $this->module->assetsUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<? echo $this->module->assetsUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<? echo $this->module->assetsUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<? echo $this->module->assetsUrl; ?>/css/main.css" />

	<title><? echo CHtml::encode($this->pageTitle); ?></title>

	<script type="text/javascript" src="<? echo $this->module->assetsUrl; ?>/js/main.js"></script>

</head>

<body>

<div class="container" id="page">
	<div id="header">
		<div class="top-menus">
		<? echo CHtml::link('help','http://www.yiiframework.com/doc/guide/topics.gii'); ?> |
		<? echo CHtml::link('webapp',Yii::app()->homeUrl); ?> |
		<a href="http://www.yiiframework.com">yii</a>
		<? if(!Yii::app()->user->isGuest): ?>
			| <? echo CHtml::link('logout',array('/gii/default/logout')); ?>
		<? endif; ?>
		</div>
		<div id="logo"><? echo CHtml::link(CHtml::image($this->module->assetsUrl.'/images/logo.png'),array('/gii')); ?></div>
	</div><!-- header -->

	<? echo $content; ?>

</div><!-- page -->

<div id="footer">
	<? echo Yii::powered(); ?>
	<br/>A product of <a href="http://www.yiisoft.com">Yii Software LLC</a>.
</div><!-- footer -->

</body>
</html>