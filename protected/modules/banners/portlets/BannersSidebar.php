<?php

 
class BannersSidebar extends Portlet
{
    public function renderContent()
    {
        $cond = 'is_active = 1 AND id IN (
                    SELECT banner_id FROM banners_roles WHERE role = "' . Yii::app()->user->role . '"
                )
                ORDER BY priority';

        $banners = Banner::model()->findAll($cond);

        foreach ($banners as $i => $banner)
        {
            if ($banner->date_start && (strtotime($banner->date_start) > time()))
            {
                unset($banners[$i]);
            }

            if ($banner->date_end && (strtotime($banner->date_end) <= time()))
            {
                unset($banners[$i]);
            }

            if (!$banner->image || !file_exists($_SERVER['DOCUMENT_ROOT'] . Banner::IMAGES_DIR . $banner->image))
            {
                unset($banners[$i]);
            }
        }

        $this->render('BannersSidebar', array('banners' => $banners));
    }
}
