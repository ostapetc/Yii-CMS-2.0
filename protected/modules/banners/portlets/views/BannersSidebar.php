<?php
foreach($banners as $banner)
{
	$img = $banner -> render(true);
	if(($url = $banner -> getHref()))
	{
		$url = Yii::app()->controller->createRedirectUrl($url, $banner->id, 'banners');
		echo CHtml::link($img, $url, array(
			'title' => $banner -> name,
		));
	}
	else
	{
		echo $img;
	}
}