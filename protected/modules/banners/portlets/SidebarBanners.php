<?php
class SidebarBanners extends Portlet
{
    public $id = 'sidebar-banners-wrapper';

    public function renderContent()
    {
        $cond = 'id IN (
                    SELECT banner_id FROM banners_roles WHERE role = "' . Yii::app()->user->role . '"
                )';


        $banners = Banner::model()->published()->ordered()->findAll($cond);
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

            if (!$banner->image ||
                !file_exists($_SERVER['DOCUMENT_ROOT'] . Banner::IMAGES_DIR . $banner->image)
            )
            {
                unset($banners[$i]);
            }
        }

        $this->widget('BootPopover', array(
            'selector' => '#' . $this->id.' img',
            'options'  => array(
                'placement' => 'right',
            )
        ));

        $this->render('SidebarBanners', array('banners'=>$banners));
    }
}
