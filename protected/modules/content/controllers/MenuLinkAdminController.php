<?php

class MenuLinkAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "Index"        => "Управление ссылками меню",
            "AjaxFillTree" => "Загрузка дерева ссылок",
            "Update"       => "Редактирование ссылки меню",
            "Create"       => "Добавление ссылки меню",
            "View"         => "Просмотр ссылки меню",
            "Delete"       => "Удаление ссылки меню",
        );
    }


    public function actionIndex($menu_id)
    {
        $menu = Menu::model()->findByPk((int)$menu_id);
        if ($menu === null)
        {
            $this->pageNotFound();
        }

        $model = MenuLink::model();

        $this->render('index', array(
            'model' => $model,
            'menu'  => $menu
        ));
    }


    public function actionAjaxFillTree()
    {
        $parent_id = null;

        if (isset($_GET['root']) && $_GET['root'] != 'source')
        {
            $parent_id = (int)$_GET['root'];
        }


        $links = MenuLink::model()->findAllByAttributes(array(
            'parent_id' => $parent_id,
            'menu_id'   => $_GET['menu_id']
        ), array('order' => '`order`'));

        foreach ($links as $ind => $link)
        {
            $has_childs = (bool)$link->childs;

            $buttons = "&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href='" . $this->createUrl('create', array(
                'menu_id'   => $link->menu_id,
                'parent_id' => $link->id
            )) . "'>
                            <img border='0' src='/img/icons/add.png' />
                        </a>
            			&nbsp;
                        <a href='" . $this->createUrl('update', array('id' => $link->id)) . "'>
                            <img border='0' src='/img/icons/update.png' />
                        </a>
                        &nbsp;
                        <a href='' class='delete_menu_link' link_id='{$link->id}'>
                            <img border='0' src='/img/icons/delete.png' />
                        </a>
                        ";

            $links[$ind]                = $link->attributes;
            $links[$ind]['hasChildren'] = $has_childs;

            $links[$ind]['text'] = $links[$ind]['title'] . $buttons;
        }

        echo CJSON::encode($links);
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        $form = new BaseForm('content.MenuLinkForm', $model);

        if ($form->submitted('submit'))
        {
            if (!$_POST['MenuLink']['page_id'])
            {
                $model->scenario = 'pageRefNull';
            }
            $model = $form->model;

            if ($model->save())
            {
                $this->redirect($this->createUrl('index', array('menu_id' => $model->menu_id)));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'form'  => $form
        ));
    }


    public function actionCreate($menu_id, $parent_id = null)
    {
        $menu = Menu::model()->findByPk($menu_id);
        if ($menu === null)
        {
            throw new CException("Меню c id '{$menu_id}' не найдено!");
        }

        $criteria         = new CDbCriteria();
        $criteria->select = 'MAX(`order`) AS max_order';
        $criteria->compare('parent_id', $parent_id);
        $criteria->compare('menu_id', $menu->id);

        $max_order = MenuLink::model()->find($criteria)->max_order;

        $model            = new MenuLink();
        $model->menu_id   = $menu->id;
        $model->parent_id = $parent_id;
        $model->order     = ++$max_order;

        $form = new BaseForm('content.MenuLinkForm', $model);
        $this->performAjaxValidation($model);

        if ($form->submitted('submit'))
        {
            if (!$_POST['MenuLink']['page_id'])
            {
                $model->scenario = 'pageRefNull';
            }

            $model = $form->model;
            if ($model->save())
            {
                $this->redirect($this->createUrl('index', array('menu_id' => $model->menu_id)));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'form'  => $form
        ));
    }


    public function actionView($menu_id)
    {
        $model = MenuLink::model();

        $links = $model->findAllByAttributes(array('menu_id' => $menu_id), array('order' => '`order`'));

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
        $link = $this->loadModel($id);

        $menu_id = $link->menu_id;

        $link->delete();

        $this->redirect(array('/content/menuLinkAdmin/index/', 'menu_id' => $menu_id));
    }

}
