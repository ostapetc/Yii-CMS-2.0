<?

class FileManagerBehavior extends ActiveRecordBehavior
{
    public $tags = array();

    public function attach($owner)
    {
        parent::attach($owner);
        $this->addRelations();
    }

    private function addRelations()
    {
        $model = $this->getOwner();
        foreach ($this->tags as $tag => $data)
        {
            $storage_class = isset($data['class']) ? $data['class'] : 'MediaFile';
            $model->getMetaData()->addRelation($tag, array(
                CActiveRecord::HAS_MANY,
                $storage_class,
                "object_id",
                'condition' => "$tag.model_id=:model_id AND $tag.tag=:tag",
                'order'     => "$tag.order DESC",
                'params'    => array(
                    'model_id' => get_class($model),
                    'tag' => $tag
                )
            ));
            $rel = $tag.'_first';
            $model->getMetaData()->addRelation($rel, array(
                CActiveRecord::HAS_ONE,
                $storage_class,
                'object_id',
                'condition' => "$rel.model_id=:model_id AND $rel.tag=:tag",
                'order'     => "$rel.order DESC",
                'params'    => array(
                    'model_id' => get_class($model),
                    'tag' => $tag
                )
            ));
        }
    }


    private function _tmpPrefix()
    {
        $prefix = 'tmp_' . get_class($this->getOwner()) . '_';
        //in console we have no user
        $prefix .= Yii::app() instanceof CConsoleApplication ? 'console' : Yii::app()->user->id;
        return  $prefix;
    }

    public function findAllAttaches()
    {
        $model     = $this->getOwner();
        $object_id = $model->isNewRecord ? $this->_tmpPrefix() : $model->id;

        MediaFile::model()->findAllByAttributes(array(
            'object_id' => $object_id,
            'model_id'  => get_class($model)
        ));

        return MediaFile::model()->findAllByAttributes(array(
            'object_id' => $object_id,
            'model_id'  => get_class($model)
        ));
    }

    //Это на случай если комменты будут создаваться до того, как создана модель
    public function afterSave($event)
    {
        $model = $this->getOwner();
        if ($model->isNewRecord)
        {
            foreach ($this->findAllAttaches() as $attach)
            {
                $attach->object_id = $model->id;
                $attach->save();
            }
        }

        parent::afterSave($event);
    }

    public function beforeDelete($event)
    {
        foreach ($this->findAllAttaches() as $attach)
        {
            $attach->delete();
        }

        parent::beforeDelete($event);
    }

}
