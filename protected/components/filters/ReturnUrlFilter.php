<?
class ReturnUrlFilter extends CFilter
{
    protected function postFilter($filterChain)
    {
        $app     = Yii::app();
        $request = $app->getRequest();


        if (!$request->getIsAjaxRequest())
        {
            $app->getUser()->setReturnUrl($request->getUrl());
        }
        return true;
    }
}