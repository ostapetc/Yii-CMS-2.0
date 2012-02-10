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
            $too_early = $banner->date_start && (strtotime($banner->date_start) > time());
            $too_late  = $banner->date_end && (strtotime($banner->date_end) <= time());
            $no_file   = !$banner->image ||
                !file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . Banner::IMAGES_DIR . '/' . $banner->image);

            if ($too_early || $too_late || $no_file)
            {
                unset($banners[$i]);
            }
        }

        $this->widget('BootPopover', array(
            'selector' => '#' . $this->id . ' img',
            'options'  => array(
                'placement' => 'right',
            )
        ));

        $this->render('SidebarBanners', array('banners'=> $banners));
    }
}
