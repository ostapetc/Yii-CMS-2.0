<?php
Yii::import('content.commands.parsers.ContentParserAbstract', true);

class SherdogGalleryParser extends CConsoleCommand
{
    public function actionIndex()
    {
        $m = new Mongo('localhost:27017');
        $db = $m->mma;
        $collection = $db->sherdog_gallery;
        foreach ($collection->find() as $gallery)
        {
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
                $collection->update(['id' => $gallery['id']], [
                    'status' => 'parsed',
                ]);
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
