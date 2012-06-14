<?php
class BigBanners extends Portlet
{
    public function renderContent()
    {
        if (!in_array(Yii::app()->request->url, array('/', '/index.php')))
        {
            return '';
        }
        $banners = Banner::model()->authObject()->ordered()->findAll('is_big = 1 && is_active = 1');

        $banners = Banner::filter($banners);

        $this->render('BigBanners', array('banners' => $banners));
    }
}
