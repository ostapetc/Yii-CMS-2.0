<?php
Yii::import('content.commands.parsers.ContentParserAbstract', true);

class SherdogGalleryParser extends CConsoleCommand
{
    public function parse()
    {
        $m = new Mongo();
        $db = $m->mma;
        $collection = $db->serdog_gallery;
//        $obj = array( "title" => "Calvin and Hobbes", "author" => "Bill Watterson" );
//        $collection->insert($obj);
//        $obj = array( "title" => "XKCD", "online" => true );
//        $collection->insert($obj);
        $cursor = $collection->find();
        foreach ($cursor as $obj) {
            echo $obj["title"] . "\n";
        }

//        $this->saveGallery($gallery);
    }

    protected function saveGallery($gallery)
    {
        $album            = new MediaAlbum();
        $album->title     = $gallery['title'];
        $album->model_id  = 'sherdog.com';
        $album->object_id = $gallery['id'];
        $album->save(false);

        foreach ($gallery['imgs'] as $img)
        {
            $file            = new MediaFile('create', 'remote');
            $file->model_id  = get_class($album);
            $file->object_id = $album->id;
            $file->tag       = 'images';
            $file->title     = $img['title'];
            $file->remote_id = $img['img'];
            $file->save(false);
        }
    }
}
