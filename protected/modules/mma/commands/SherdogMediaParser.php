<?php
Yii::import('content.commands.parsers.ContentParserAbstract', true);

class SherdogMediaParser extends CConsoleCommand
{
    public function actionIndex()
    {
        $m = new Mongo('localhost:27017');
        $this->parseAlbum($m->mma);
        $this->parseVideo($m->mma);
    }

    protected function parseVideo($db)
    {
        $collection = $db->sherdog_video;
        foreach ($collection->find() as $video)
        {
            $model = MediaFile::model()->findByAttributes([
                'source' => 'sherdog.com',
                'source_id' => $video['id']
            ]);
            if ($model)
            {
                continue;
            }

            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $this->saveVideo($video);
                $transaction->commit();
                $video['status'] = 'parsed';
                $collection->update(['id' => $video['id']], $video);
            }
            catch(Exception $e)
            {
                $transaction->rollback();
                $collection->remove(['id' => $video['id']]);
                Yii::log($e, CLogger::LEVEL_ERROR);
            }
        }
    }

    protected function saveVideo($video)
    {
        if (isset($video['status']) && $video['status'] == 'parsed')
        {
            return true;
        }
        $user = User::model()->findByAttributes(['email' => 'www.pismeco@gmail.com']);

        $file            = new MediaFile('insert', 'remote');
        $file->model_id  = get_class($user);
        $file->object_id = $user->id;
        $file->tag       = 'files';
        $file->title     = $video['title'];
        $file->type      = MediaFile::TYPE_VIDEO;
        $file->remote_id = $video['url'];
        if (!$file->save())
        {
            throw new CException(json_encode($file->getErrors()));
        }
    }

    protected function parseAlbum($db)
    {
        $collection = $db->sherdog_gallery;
        foreach ($collection->find() as $gallery)
        {
            if (isset($gallery['status']) && $gallery['status'] == 'parsed')
            {
                continue;
            }
            $model = MediaAlbum::model()->findByAttributes([
                'source' => 'sherdog.com',
                'source_id' => $gallery['id']
            ]);
            if ($model)
            {
                continue;
            }
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $this->saveGallery($gallery);
                $transaction->commit();
                $gallery['status'] = 'parsed';
                $collection->update(['id' => $gallery['id']], $gallery);
            }
            catch(Exception $e)
            {
                $transaction->rollback();
                $collection->remove(['id' => $gallery['id']]);
                Yii::log($e, CLogger::LEVEL_ERROR);
            }
        }
    }

    protected function saveGallery($gallery)
    {
        $user = User::model()->findByAttributes(['email' => 'www.pismeco@gmail.com']);

        $album            = new MediaAlbum();
        $album->title     = $gallery['title'];
        $album->model_id  = get_class($user);
        $album->object_id = $user->id;
        $album->source    = 'sherdog.com';
        $album->source_id = $gallery['id'];
        $album->status    = MediaAlbum::STATUS_ACTIVE;
        if (!$album->save())
        {
            throw new CException(json_encode($album->getErrors()));
        }

        $order = 0;
        foreach ($gallery['imgs'] as $img)
        {
            if (!$img['path'])
            {
                continue;
            }
            $file            = new MediaFile('insert', 'local');
            $file->model_id  = get_class($album);
            $file->object_id = $album->id;
            $file->tag       = 'files';
            $file->title     = $img['title'];
            $file->remote_id = $img['path'];
            $file->order     = ++$order;
            $file->getApi()->need_upload = false;
            if (!$file->save())
            {
                throw new CException(json_encode($file->getErrors()));
            }
        }
    }
}
