<?

class TagBehavior extends ActiveRecordBehavior
{
    public function afterSave($event)
    {
        $model_id = get_class($this->owner);

        if (!isset($_POST[$model_id]['tags']))
        {
            return true;
        }

        $tags = explode(',', $_POST[$model_id]['tags']);
        $ids = [];

        foreach ($tags as $tag_name)
        {
            $tag = Tag::model()->findByAttributes(['name' => $tag_name]);
            if (!$tag)
            {
                continue;
            }
            $ids[] = $tag->id;

            $exists = TagRel::model()->existsByAttributes([
                'tag_id' => $tag->id,
                'object_id' => $this->owner->id,
                'model_id' => $model_id
            ]);

            if ($exists)
            {
                continue;
            }

            $tag_rel = new TagRel();
            $tag_rel->tag_id    = $tag->id;
            $tag_rel->object_id = $this->owner->id;
            $tag_rel->model_id  = $model_id;
            $tag_rel->save();
        }
        $this->_deleteRels($ids);
    }


    public function _deleteRels($exclude_ids)
    {
        $criteria = new CDbCriteria([
            'condition' => 'model_id=:model_id AND object_id=:object_id',
            'params' => [
                'object_id' => $this->owner->id,
                'model_id' => get_class($this->owner)
            ]
        ]);
        $criteria->addNotInCondition('tag_id', $exclude_ids);
        TagRel::model()->deleteAll($criteria);
    }
}









