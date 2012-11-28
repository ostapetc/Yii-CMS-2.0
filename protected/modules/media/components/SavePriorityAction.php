<?php
class SavePriorityAction extends CAction
{
    public function run()
    {
        $ids = array_reverse($_POST['File']);

        $files = new MediaFile('sort');

        $case = SqlHelper::arrToCase('id', array_flip($ids), 't');
        $arr  = implode(',', $ids);
        Yii::app()->db->getCommandBuilder()
            ->createSqlCommand("UPDATE {$files->tableName()} AS t SET t.order = {$case} WHERE t.id IN ({$arr})")
            ->execute();
    }

}
