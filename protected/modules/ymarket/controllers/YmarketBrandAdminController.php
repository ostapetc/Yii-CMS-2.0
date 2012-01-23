<?php

class YmarketBrandAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Manage' => 'Бренды',
        );
    }

	public function actionManage()
	{
		$model=new YmarketBrand('search');
		$model->unsetAttributes();
		if(isset($_GET['YmarketBrand']))
        {
            $model->attributes = $_GET['YmarketBrand'];
        }

		$this->render('manage', array(
			'model' => $model,
		));
	}
}
