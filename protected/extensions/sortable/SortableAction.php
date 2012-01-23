<?php
class SortableAction extends CAction
{
    public function run()
    {
        $model = new $_POST['model'];
        $column = 'order'; //потом надо будет передавать еще и поле сортировки, если их будет несколько

        if (isset($_POST['pk']) && is_array($_POST['pk']))
        {
            //это что бы не париться со страницами
            $i = $model
                ->in('id', $_POST['pk'])
                ->max($column);

            if ($i == 0 || !is_numeric($i)) //если битое значение заполняем все айдишниками
            {
                $model->fillOrderColumn($column);
            }

            $model->setPositions($_POST['pk'], $column, $i);
        }
    }
}
