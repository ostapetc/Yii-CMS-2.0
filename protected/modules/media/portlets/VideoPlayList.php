<?php
Yii::import('media.portlets.BaseFileListView', true);

class VideoPlayList extends Widget
{
    public $request = 'MMA';
    public $author;
    public $items_count = 4;

    public function run()
    {

        $file = new MediaFile;
        $dp = new ActiveDataProvider($file, [
            'criteria' => $file->parentModel(Yii::app()->controller->user, true)->type(MediaFile::TYPE_VIDEO)->getDbCriteria(),
            'pagination' => false
        ]);

        $this->render('_videoPlayList', [
            'data' => $dp->getData()
        ]);
    }
}