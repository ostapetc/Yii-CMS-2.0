<?

class PageAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return [
            "manage"      => t("Управление страницами"),
            "create"      => t("Добавление страницы"),
            "view"        => t("Просмотр страницы"),
            "update"      => t("Редактирование страницы"),
            "delete"      => t("Удаление страницы"),
            "getJsonData" => t("Получение данных страницы (JSON)"),
            "deleteAll"   => t("Удалить все посты")
        ];
    }


    public function actionManage()
    {
        $model = new Page('search');
        $model->unsetAttributes();

        if (isset($_GET['Page']))
        {
            $model->attributes = $_GET['Page'];
        }

        $this->render('manage', [
            "model" => $model
        ]);
    }


    public function actionCreate()
    {
        $model = new Page(ActiveRecord::SCENARIO_CREATE);
        $form  = new Form('content.PageForm', $model);
        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
        {
            $this->redirect([
                'view',
                'id' => $model->id
            ]);
        }
        $this->render('create', ['form' => $form]);
    }


    public function actionView($id)
    {
        $model = $this->loadModel($id);

        if (isset($_GET['json']))
        {
            echo CJSON::encode($model);
        }
        else
        {
            $this->render('view', ['model' => $model]);
        }
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $form  = new Form('content.PageForm', $model);

        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
        {
            $this->redirect([
                'view',
                'id' => $model->id
            ]);
        }

        $this->render('update', [
            'form' => $form,
        ]);
    }


    public function actionDelete()
    {
        die;
        $this->loadModel($id)->delete();

        if (!isset($_GET['ajax']))
        {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['admin']);
        }
    }


    public function actionGetJsonData($id)
    {
        echo CJSON::encode($this->loadModel($id));
    }


    public function actionDeleteAll()
    {
        Page::model()->deleteAll();
        $this->redirect('manage');
    }
}
