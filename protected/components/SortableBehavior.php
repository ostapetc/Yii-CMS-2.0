<?php
class SortableBehavior extends CActiveRecordBehavior
{
    public function swapPosition($fromId, $toId)
    {
        $owner = $this->getOwner();
        $from = $owner->model()->findByPk($fromId);
        $to = $owner->model()->findByPk($toId);
        $to->scenario = $from->scenario = 'movePosition';

        //swap
        list($from->priority, $to->priority) = array($to->priority, $from->priority);
        $transaction=Yii::app()->db->beginTransaction();
        try {
            if ($from->save() && $to->save())
                $transaction->commit();
            else
                throw new CException('movePosition error');

        } catch(Exception $e) {
            $transaction->rollBack();
        }
    }

    public function setPositions($ids, $table, $criteria=null)
    {
        $criteria = $criteria ? $criteria : new CDbCriteria();
        $owner = $this->getOwner();
        $pk = $owner->primaryKey();
        
        //last id have 0 priority => revers => first id have 0 priority => flip => every id have their priority
        $priorities = array_flip(array_reverse($ids));
        $data = array('priority' => Sql::arrToCase($pk, $priorities));

        $c = Yii::app()->db->commandBuilder
            ->createUpdateCommand($table, $data, $criteria);

        Y::dump($c->execute());
    }

    /**
     * @return CActiveRecord Season
     */
    public function mostPriority()
    {
        $owner = $this->getOwner();
        $alias = $owner->getTableAlias();
        $owner->getDbCriteria()->mergeWith(array(
            'limit' => 1,
            'order' => $alias.'.priority DESC'
        ));
        return $owner;
    }

    public function setDefaultPriority()
    {
        $owner = $this->getOwner();
        $model = $owner->model()->mostPriority()->find();
        $owner->priority = $model->priority + 1;
    }
    
    
}