<?

class TagBehavior extends ActiveRecordBehavior
{
    private static $_tags;


    public function afterSave($event)
    {
        //parent::afterSave($event);


        //$this->_deleteRels();

//        $tags = Yii::app()->request->getParam('Tag');
//        if ($tags)
//        {
//
//        }

        return parent::afterSave($event);
    }


//    public function afterDelete($event)
//    {
//        $this->_deleteRels();
//        return parent::afterDelete($event);
//    }


//    private function _deleteRels()
//    {
//        TagRel::model()->deleteAllByAttributes(array(
//            'object_id' => $this->owner->id,
//            'model_id'  => get_class($this->owner)
//        ));
//    }


    public function initFormElements($event)
    {
        $elements = $event->sender->getElements();
        $elements['tags'] = array(
            'type' => 'application.components.formElements.TagsInput.TagsInput'
        );
        $event->sender->setElements($elements);
    }

}










