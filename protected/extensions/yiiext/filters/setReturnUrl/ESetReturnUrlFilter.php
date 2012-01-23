<?php
/**
* SetReturnUrl Filter
*
* Keep current URL (if it's not an AJAX url) in session so that the browser may
* be redirected back.
* @version 1.0.2
* @author creocoder <creocoder@gmail.com>
*/

class ESetReturnUrlFilter extends CFilter
{
	protected function preFilter($filterChain)
	{
		$app=Yii::app();
		$request=$app->getRequest();

		if(!$request->getIsAjaxRequest())
			$app->getUser()->setReturnUrl($request->getUrl());

		return true;
	}
}