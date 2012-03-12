<?php

class MenuSectionAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "Roots"            => "Меню сайта",
            "Update"           => "Редактирование ссылки меню",
            "Create"           => "Добавление ссылки меню",
            "View"             => "Просмотр ссылки меню",
            "Delete"           => "Удаление ссылки меню",
            "Sorting"          => "Сортировка",
            "Manage"           => "Управление ссылками меню",
            "UpdateTree"       => "Редактирование дерева",
        );
    }

    public function actionRoots()
    {
        $model = new MenuSection(ActiveRecordModel::SCENARIO_SEARCH);
        $model->unsetAttributes();

        if (isset($_GET['MenuSections']))
        {
            $model->attributes = $_GET['MenuSections'];
        }

        $this->render('manage', array('root' => null,'model'=>$model));
    }

    public function actionSorting($root_id, $menu_id)
    {
        if (isset($_POST['tree']))
        {
            $model = new MenuSection;
            $this->performAjaxValidation($model);

            //при сортировке дерева параметры корня измениться не могут,
            //поэтоtму его вообще сохранять не будем
            $data = json_decode($_POST['tree']);
            array_shift($data);

            //получаем большие case для update
            $update            = array();
            $js_to_sql_mapping = array(
                'depth'=> 'level',
                'left' => 'left',
                'right'=> 'right'
            );
            foreach ($js_to_sql_mapping as $js_field=> $field)
            {
                $update_data = CHtml::listData($data, 'item_id', $js_field);
                $update[]    = "t.{$field} = " . SqlHelper::arrToCase('id', $update_data, 't');
            }
            $in        = implode(', ', array_values(CHtml::listData($data, 'item_id', 'item_id')));
            $condition = "t.level > 1";
            $command   = Yii::app()->db->commandBuilder->createSqlCommand(
                "UPDATE `{$model->tableName()}` as t SET " . implode(', ', $update) .
                    " WHERE {$condition} AND t.id IN ({$in})");
            $command->execute();
            echo CJSON::encode(array(
                'status'  => 'ok',
                'redirect'=> $this->createUrl('manage', array('menu_id'=> $menu_id))
            ));
            Yii::app()->end();
        }
        $this->render('sorting', array(
            'root_id' => $root_id,
            'menu_id' => $menu_id
        ));
    }


    public function loadMenuModel($menu_id)
    {
        $menu = Menu::model()->findByPk((int)$menu_id);
        if (!$menu)
        {
            $this->pageNotFound();
        }
        return $menu;
    }


    public function actionUpdate($id, $back)
    {
        $model = $this->loadModel($id);
        $model->detachBehavior('NestedSet');

        $form = new BaseForm('content.MenuSectionForm', $model);
        $this->performAjaxValidation($model);

        if ($form->submitted('submit'))
        {
            $model->page_id = $model->module_id = $model->module_url = '';
            if ($model->url_info)
            {
                $info = explode(':', $model->url_info);
                if ($info[0] === 'page')
                {
                    $model->page_id = $info[1];
                }
                else if ($info[0] === 'module')
                {
                    $model->module_id  = $info[1];
                    $model->module_url = $info[2];
                }
            }

            if ($model->save())
            {
                $this->redirect($this->createUrl($back, array('menu_id' => $model->menu_id)));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'form'  => $form,
            'back'  => $back
        ));
    }


    public function actionCreate($menu_id, $parent_id, $back)
    {
        $parent = MenuSection::model()->findByPk($parent_id);
        if (!$parent)
        {
            $this->pageNotFound();
        }

        $menu = $this->loadMenuModel($menu_id);

        $criteria = new CDbCriteria();
        $criteria->compare('menu_id', $menu->id);

        $model          = new MenuSection();
        $model->menu_id = $menu->id;

        $form = new BaseForm('content.MenuSectionForm', $model);
        $this->performAjaxValidation($model);

        if ($form->submitted('submit'))
        {
            $model->page_id = $model->module_id = $model->module_url = '';
            if ($model->url_info)
            {
                $info = explode(':', $model->url_info);
                if ($info[0] === 'page')
                {
                    $model->page_id = $info[1];
                }
                else if ($info[0] === 'module')
                {
                    $model->module_id  = $info[1];
                    $model->module_url = $info[2];
                }
            }


            if ($model->validate())
            {
                $model->appendTo($parent);
                $this->redirect(array(
                    $back,
                    'menu_id' => $menu_id
                ));
            }
        }
        $this->render('create', array(
            'model' => $model,
            'menu'  => $menu,
            'form'  => $form,
            'back'  => $back
        ));
    }


    public function actionView($menu_id)
    {
        $model = MenuSection::model();

        $links = $model->findAllByAttributes(array('menu_id' => $menu_id));

        $roles = Role::model()->findAll();
        foreach ($roles as $ind => $role)
        {
            $roles[$role->name] = $role->description;
        }

        $this->render('view', array(
            'links' => $links,
            'roles' => $roles,
            'meta'  => $model->meta()
        ));
    }


    public function actionDelete($id)
    {
        $this->loadModel($id)->deleteNode();
    }


    public function actionManage($root_id)
    {
        $root = MenuSection::model()->roots()->findByPk($root_id);

        $model = new MenuSection('search');
        $model->unsetAttributes();

        if (isset($_GET['MenuSection']))
        {
            $model->attributes = $_GET['MenuSection'];
        }

        $this->render('manage', array(
            'model' => $model,
            'root'  => $root
        ));
    }
}
