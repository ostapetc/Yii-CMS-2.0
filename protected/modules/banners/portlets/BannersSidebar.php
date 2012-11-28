<?php

 
class BannersSidebar extends Portlet
{
    public function renderContent()
    {
        $banners = Banner::model()->ordered()->findAll('is_big = 0 && is_active = 1');
        $banners = Banner::filter($banners);

        $this->render('BannersSidebar', array('banners' => $banners));
    }
}
