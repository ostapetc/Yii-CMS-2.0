<?php

class ManyManySortableBehavior extends CActiveRecordBehavior
{
    public $relation;
    public $map_field;

    public function attach($owner)
    {
        parent::attach($owner);
    }

    //заполняем айдишниками
    public function fillOrderColumn($column)
    {
        $model = $this->getOwner();
        $c     = Yii::app()->db->commandBuilder->createSqlCommand(
            "UPDATE " . $model->tableName() . " AS t SET t.{$column} = t.id");

        $c->execute();
    }

    public function setPositions($ids, $column, $start)
    {
        list($table, $fk1, $fk2) = SqlHelper::parseManyMany($this->owner, $this->relation);

        $model = $this->getOwner();
        $table = $model->tableName();

        $priorities = array();
        foreach ($ids as $id)
        {
            $priorities[$id] = $start--;
        }

        $case = SqlHelper::arrToCase('id', $priorities, $model->getTableAlias());
        $c    = Yii::app()->db->commandBuilder->createSqlCommand("UPDATE {$table} AS t SET t.{$column} = {$case}");
        $c->execute();
    }

    public function setOrderPositions($prev, $curr, $next, $cat_id)
    {
        list($table, $fk1, $fk2) = SqlHelper::parseManyMany($this->owner, $this->relation);

        $db      = Yii::app()->db;
        $command = $db->createCommand();

        if ($prev != -1)
        {
            $prevO = $command->select($this->map_field)->from($table)
                ->where("{$fk1}=:product_id AND {$fk2}=:category_id ", array(
                ':product_id' => $prev,
                ':category_id'=> $cat_id,
            ))->queryScalar();
        }
        if ($curr != -1)
        {
            $currO = $command->select($this->map_field)->from($table)
                ->where("{$fk1}=:product_id AND {$fk2}=:category_id ", array(
                ':product_id' => $curr,
                ':category_id'=> $cat_id,
            ))->queryScalar();
        }
        if ($next != -1)
        {
            $nextO = $command->select($this->map_field)->from($table)
                ->where("{$fk1}=:product_id AND {$fk2}=:category_id ", array(
                ':product_id' => $next,
                ':category_id'=> $cat_id,
            ))->queryScalar();
        }

        if (isset($prevO) && $currO < $prevO)
        {
            $new = $prevO;
            $db
                ->createCommand("UPDATE `{$table}` SET `{$this->map_field}`=`{$this->map_field}`-1 WHERE `{$fk2}`={$cat_id} AND `{$this->map_field}`<={$prevO} AND `{$this->map_field}`>{$currO}")
                ->execute();
        }
        elseif (isset($nextO) && $currO > $nextO)
        {
            $new = $nextO;
            $db
                ->createCommand("UPDATE `{$table}` SET `{$this->map_field}`=`{$this->map_field}`+1 WHERE `{$fk2}`={$cat_id} AND `{$this->map_field}`>={$nextO} AND `{$this->map_field}`<{$currO}")
                ->execute();
        }

        if (isset($new))
        {
            $command->update($table, array(
                $this->map_field => $new,
            ), "`{$fk1}`=:product_id AND `{$fk2}`=:category_id", array(
                ':product_id' => $curr,
                ':category_id'=> $cat_id,
            ));
        }
    }

    public function beforeSave($event)
    {
        $model = $this->getOwner();

        if ($model->isNewRecord)
        {
            $i                         = $model->max($this->map_field);
            $model->{$this->map_field} = ++$i;
        }
    }

    public function initOrder()
    {
        list($table, $fk1, $fk2) = SqlHelper::parseManyMany($this->owner, $this->relation);
        $model = $this->getOwner();

        $category_ids = CHtml::listData($model->{$this->relation}, 'id', 'id');
        if (!$category_ids)
        {
            return true;
        }

        $builder = Yii::app()->db->getCommandBuilder();

        $criteria         = new CDbCriteria();
        $criteria->select = "MAX(`{$this->map_field}`)";
        $command          = Yii::app()->db->createCommand()->select('id')->from($table);
        foreach ($category_ids as $cat_id)
        {
            $comm = clone $command;
            $id   = $comm->where(array(
                'and',
                "`{$fk1}`={$model->getPrimaryKey()}",
                "`{$fk2}`={$cat_id}",
                "`{$this->map_field}`=0",
                array(
                    'in',
                    $fk2,
                    $category_ids
                )
            ))->queryScalar();

            $cr = clone $criteria;
            $cr->addCondition('t.' . $fk2 . '=' . $cat_id);

            $max = $builder->createFindCommand($table, $cr)->queryScalar();

            $max++;
            Yii::app()->db
                ->createCommand("UPDATE `{$table}` SET  `{$this->map_field}`={$max} WHERE `id`={$id}")
                ->execute();
        }
    }
}