<?

class FileManagerBehavior extends ActiveRecordBehavior
{
    public $attached_model;

    private function _tmpPrefix()
    {
        return 'tmp_' . $this->attached_model . '_' . Yii::app()->user->id;
    }

    public function findAllAttaches()
    {
        $model     = $this->getOwner();
        $object_id = $model->isNewRecord ? $this->_tmpPrefix() : $model->id;
        return ActiveRecord::model($this->attached_model)->findAllByAttributes(array(
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

    public function beforeFormRender($event)
    {
        $elements = $event->sender->getElements();
        $elements['file_manager'] = array( //TODO: add real data
            'type'      => 'file_manager',
            'tag'       => 'a',
            'data_type' => 'image'
        );
        $event->sender->setElements($elements);
    }
}
