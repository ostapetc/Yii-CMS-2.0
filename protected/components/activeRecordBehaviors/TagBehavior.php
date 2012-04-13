<?

class TagBehavior extends CActiveRecordBehavior
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

        die;
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
}










