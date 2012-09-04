<?

class TagBehavior extends ActiveRecordBehavior
{
    public function afterSave($event)
    {
        $this->_deleteRels();

        $model_id = get_class($this->owner);

        if (isset($_POST[$model_id]['tags']) && is_array($_POST[$model_id]['tags']))
        {
            foreach ($_POST[$model_id]['tags'] as $tag_id)
            {
                $tag = Tag::model()->findByPk($tag_id);
                if (!$tag)
                {
                    continue;
                }

                $tag_rel = new TagRel();
                $tag_rel->tag_id    = $tag_id;
                $tag_rel->object_id = $this->owner->id;
                $tag_rel->model_id  = $model_id;
                $tag_rel->save();
            }
        }
    }


    public function _deleteRels()
    {
        TagRel::model()->deleteAll("object_id = '{$this->owner->id}' AND model_id = '" . get_class($this->owner) . "'");
    }
}









