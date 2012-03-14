<?php
class ApiController extends CController
{
    public function actions()
    {
        return array(
            'json'=>array(
                'class'=>'JsonRpcAction',
            ),
            'soap'=>array(
                'class'=>'CWebServiceAction',
                'classMap'=>array(
                    'News'=>'News',  // or simply 'News'
                ),
            ),
        );
    }

    /**
     * @return array the stock price
     * @soap
     */
    public function getLastNews()
    {
        return News::model()->limit(10)->published()->findAllRaw();
    }

}


