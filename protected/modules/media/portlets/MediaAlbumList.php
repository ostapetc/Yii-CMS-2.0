<?php
class MediaAlbumList extends Widget
{
    public $user;
    public $dp;
    public $is_my;

    public function init()
    {
        $this->dp = MediaAlbum::getDataProvider(Yii::app()->user->getModel());
        $this->dp->pagination = false;
        $this->render('mediaAlbums', array(
//            'items' => $dp->getData(),
        ));
    }

}