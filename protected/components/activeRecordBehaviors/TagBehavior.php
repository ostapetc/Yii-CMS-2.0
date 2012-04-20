<?

class TagBehavior extends CActiveRecordBehavior
{
    private static $_tags;


    public function afterSave()
    {
        $this->_deleteRels();

        $model_id = get_class($this->owner);

        if (isset($_POST[$model_id]['tags']))
        {
            TagRel::model()->deleteAllByAttributes(array('model_id' => $model_id, 'object_id' => $this->owner->id));

            foreach (explode(',', $_POST[$model_id]['tags']) as $tag_name)
            {
                $tag = Tag::model()->find("name = '{$tag_name}'");
                if (!$tag)
                {
                    $tag = new Tag();
                    $tag->name = $tag_name;
                    if (!$tag->save())
                    {
                        throw new CHttpException("can't save tag");
                    }
                }

                $tag_rel = new TagRel();
                $tag_rel->tag_id    = $tag->id;
                $tag_rel->object_id = $this->owner->id;
                $tag_rel->model_id  = $model_id;
                $tag_rel->save(false);
            }
        }
    }


    public function _deleteRels()
    {
        TagRel::model()->exists("object_id = '{$this->owner->id}' AND model_id = '" . get_class($this->owner) . "'");
    }
}









