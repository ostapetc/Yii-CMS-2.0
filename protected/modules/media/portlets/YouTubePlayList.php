<?php
Yii::import('media.portlets.BaseFileListView', true);

class YouTubePlayList extends Widget
{
    public $request = 'MMA';
    public $author;
    public $items_count = 4;

    public function run()
    {
        $file = new MediaFile('search', 'youTube');
        $api  = $file->getApi();
        /** @var $api YouTubeApi */
        $api->title     = $this->request;
        $api->author    = $this->author;
        $dp             = $api->search([
            'limit' => $this->items_count
        ]);
        $dp->pagination = false;

        $this->render('_youTubeVideo', ['data' => $dp->getData()]);
    }
}