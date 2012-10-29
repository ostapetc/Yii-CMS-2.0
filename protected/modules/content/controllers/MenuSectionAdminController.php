<?

class MenuSectionAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return [
            "update"           => "Редактирование ссылки меню",
            "create"           => "Добавление ссылки меню",
            "view"             => "Просмотр ссылки меню",
            "delete"           => "Удаление ссылки меню",
            "sorting"          => "Сортировка",
            "manage"           => "Управление ссылками меню",
            "updateTree"       => "Редактирование дерева",
        ];
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
            $update            = [];
            $js_to_sql_mapping = [
                'depth'=> 'level',
                'left' => 'left',
                'right'=> 'right'
            ];
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
            echo CJSON::encode([
                'status'  => 'ok',
                'redirect'=> $this->createUrl('manage', ['menu_id'=> $menu_id])
            ]);
            Yii::app()->end();
        }
        $this->render('sorting', [
            'root_id' => $root_id,
            'menu_id' => $menu_id
        ]);
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

        $form = new Form('content.MenuSectionForm', $model);
        $this->performAjaxValidation($model);

        if ($form->submitted('submit') && $model->save())
        {
            $this->redirect($this->createUrl($back, ['menu_id' => $model->menu_id]));
        }

        $this->render('update', [
            'model' => $model,
            'form'  => $form,
            'back'  => $back
        ]);
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

        $model = new MenuSection();
        $model->menu_id = $menu->id;

        $form = new Form('content.MenuSectionForm', $model);
        $this->performAjaxValidation($model);

        if ($form->submitted('submit') && $model->validate())
        {
            $model->appendTo($parent);
            $this->redirect([
                $back,
                'menu_id' => $menu_id
            ]);
        }

        $this->render('create', [
            'model' => $model,
            'menu'  => $menu,
            'form'  => $form,
            'back'  => $back
        ]);
    }


    public function actionView($menu_id)
    {
        $model = MenuSection::model();

        $links = $model->findAllByAttributes(['menu_id' => $menu_id]);

        $roles = Role::model()->findAll();
        foreach ($roles as $ind => $role)
        {
            $roles[$role->name] = $role->description;
        }

        $this->render('view', [
            'links' => $links,
            'roles' => $roles,
            'meta'  => $model->meta()
        ]);
    }


    public function actionDelete($id)
    {
        $this->loadModel($id)->deleteNode();
    }


    public function actionManage($menu_id)
    {
        $menu = Menu::model()->findByPk($menu_id);
        if (!$menu)
        {
            $this->pageNotFound();
        }

        $root = MenuSection::model()->roots()->find('menu_id = ' . $menu_id);
        if (!$root)
        {
            $root          = new MenuSection();
            $root->menu_id = $menu->id;
            $root->title   = $menu->name . '::корень';
            $root->saveNode();
        }

        $model = new MenuSection('search');
        $model->unsetAttributes();

        if (isset($_GET['MenuSection']))
        {
            $model->attributes = $_GET['MenuSection'];
        }

        $this->render('manage', [
            'menu'  => $menu,
            'model' => $model,
            'root'  => $root
        ]);
    }
}
