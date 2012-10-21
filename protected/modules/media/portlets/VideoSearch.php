<?php

class VideoSearch extends Widget
{

    public function run()
    {
        $file = new MediaFile;
        $file->type(MediaFile::TYPE_VIDEO);
        $search = new Form('media.VideoSearch', $file);
        $this->render('videoSearch');
    }
}