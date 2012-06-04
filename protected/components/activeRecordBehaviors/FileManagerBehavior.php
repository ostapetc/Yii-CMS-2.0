<?

class FileManagerBehavior extends ActiveRecordBehavior
{
    public $tags = array();

    public function init()
    {
        parent::init();
        $this->addRelations();
    }

    private function addRelations()
    {
        $model = $this->getOwner();
        foreach ($this->tags as $tag => $data)
        {
            $storage_class = isset($data['class']) ? $data['class'] : 'FileManager';
            $model->getMetaData()->addRelation($tag, array(
                CActiveRecord::HAS_MANY,
                $storage_class,
                'object_id',
                'condition' => "$tag.model_id = '" . get_class($model) . "' AND $tag.tag='$tag'",
                'order'     => '$tag.order DESC'
            ));
        }
    }

    private function _tmpPrefix()
    {
        return 'tmp_' . get_class($this->getOwner()) . '_' . Yii::app()->user->id;
    }

    public function findAllAttaches()
    {
        $model     = $this->getOwner();
        $object_id = $model->isNewRecord ? $this->_tmpPrefix() : $model->id;
        return ActiveRecord::model(get_class($this->getOwner()))->findAllByAttributes(array(
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

        return parent::afterSave($event);
    }

    public function beforeDelete($event)
    {
        foreach ($this->findAllAttaches() as $attach)
        {
            $attach->delete();
        }

        return parent::beforeDelete($event);
    }

    public function beforeFormInit($event)
    {
        $elements = $event->sender->getElements();

        foreach ($this->tags as $tag => $data)
        {
            if (is_string($data))
            {
                $elements['file_manager_'.$data] = array(
                    'type'      => 'file_manager',
                    'tag'       => $tag,
                    'data_type' => 'image',
                    'title'     => $data
                );
            }
            elseif (is_array($data))
            {
                $elements['file_manager_'.$data['title']] = array(
                    'type'      => 'file_manager',
                    'tag'       => $tag,
                    'data_type' => $data['data_type'],
                    'title'     => $data['title']
                );
            }
        }

        $event->sender->setElements($elements);
    }

}
