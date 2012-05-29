<?

class MenuAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "create" => "Добавление меню",
            "update" => "Редактирование меню",
            "manage" => "Управление меню",
            "delete" => "Удаление меню",
        );
    }


    public function actionCreate()
    {
        $model = new Menu;

        $form = new Form('content.MenuForm', $model);

        if ($form->submitted() && $model->save())
        {
            $section          = new MenuSection();
            $section->menu_id = $model->id;
            $section->title   = $model->name . '::корень';
            $section->saveNode();

            $this->redirect('/content/MenuAdmin/manage/');
        }

        $this->render('create', array('form' => $form));
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $form = new Form('content.MenuForm', $model);

        if ($form->submitted() && $model->save())
        {
            $this->redirect($this->createUrl('manage'));
        }

        $this->render('update', array('form' => $form));
    }


    public function actionManage()
    {
        $model = new Menu(ActiveRecord::SCENARIO_SEARCH);
        $model->unsetAttributes();

        if (isset($_GET['Menu']))
        {
            $model->attributes = $_GET['Menu'];
        }

        $this->render('manage', array('model' => $model));
    }


    public function actionDelete($id)
    {
        $model = $this->loadModel($id)->delete();

        $this->redirect($this->createUrl('manage'));
    }

}
