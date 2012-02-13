<?php
class DocumentationAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "Create"                => "Добавление меню",
            "Update"                => "Редактирование меню",
            "Manage"                => "Управление меню",
            "Delete"                => "Удаление меню",
            "Sorting"               => "Сортировка",
        );
    }


    public function actionCreate($parent_id = null)
    {
        $parent = $this->loadModel($parent_id);

        $model = new Documentation;

        $form = new BaseForm('docs.DocumentationForm', $model);
        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->appendTo($parent) && $model->save())
        {
            $this->redirect($model->manageUrl);
        }

        $this->render('create', array('form' => $form));
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $form  = new BaseForm('docs.DocumentationForm', $model);
        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
        {
            $this->redirect($model->manageUrl);
        }

        $this->render('update', array('form' => $form));
    }


    public function actionManage()
    {
        $model = new Documentation();

        $this->render('manage', array('model' => $model));
    }


    public function actionDelete($id)
    {
        $model = $this->loadModel($id);

        if (!$model->is_system)
        {
            $model->deleteNode();
        }
    }


    public function actionSorting()
    {
        if (isset($_POST['tree']))
        {
            $model = new Category;

            $this->performAjaxValidation($model);

            //при сортировке дерева параметры корня измениться не могут,
            //поэтоtму его вообще сохранять не будем
            $data = json_decode($_POST['tree']);
            array_shift($data);

            //получаем большие case для update
            $update               = array();
            $nestedSortableFields = array(
                'depth'=> Category::DEPTH,
                'left' => Category::LFT,
                'right'=> Category::RGT
            );
            foreach ($nestedSortableFields as $key => $field)
            {
                $update_data = CHtml::listData($data, 'item_id', $key);
                $update[]    = "{$field} = " . SqlHelper::arrToCase('id', $update_data);
            }

            //обновляем всю таблицу, кроме рута
            $condition = Category::DEPTH . " > 1";
            $command   = Yii::app()->db->commandBuilder->createSqlCommand(
                "UPDATE `{$model->tableName()}` SET " . implode(', ', $update) . " WHERE {$condition}");
            $command->execute();
            echo CJSON::encode(array(
                'status'  => 'ok',
                'redirect'=> $this->createUrl('manage')
            ));
            Yii::app()->end();
        }
        $this->render('sorting');
    }


}
