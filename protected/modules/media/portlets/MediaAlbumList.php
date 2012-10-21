<?php
class MediaAlbumList extends Widget
{
    public $positive = true;
    public $dp;
    public $is_my;
    public $title;

    public function init()
    {
        $this->render('mediaAlbums', [
            'dp' => $this->dp,
        ]);
    }

}