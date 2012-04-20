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
                p($tag_rel->errors);
                v($tag_rel->save());
                v($tag_rel->attributes);
            }
            die;
        }

    }


    public function _deleteRels()
    {
        TagRel::model()->exists("object_id = '{$this->owner->id}' AND model_id = '" . get_class($this->owner) . "'");
    }

    public function beforeInitForm($event)
    {
        $elements = $event->sender->getElements();
        $elements['tags'] = array(
            'type' => 'application.components.formElements.TagsInput.TagsInput'
        );
        $event->sender->setElements($elements);
    }

}










