<?php
class MediaAlbumList extends Widget
{
    public $user;
    public $dp;
    public $is_my;

    public function init()
    {
        if (!$this->dp) {
            $this->dp = MediaAlbum::getDataProvider($this->user);
            $this->dp->pagination = false;
        }
        $this->render('mediaAlbums', array(
            'dp' => $this->dp,
        ));
    }

}