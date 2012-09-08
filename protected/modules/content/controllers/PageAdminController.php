<?

class PageAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "manage"      => t("Управление страницами"),
            "create"      => t("Добавление страницы"),
            "view"        => t("Просмотр страницы"),
            "update"      => t("Редактирование страницы"),
            "delete"      => t("Удаление страницы"),
            "getJsonData" => t("Получение данных страницы (JSON)")
        );
    }


    public function actionManage()
    {
        $model = new Page('search');
        $model->unsetAttributes();

        if (isset($_GET['Page']))
        {
            $model->attributes = $_GET['Page'];
        }

        $this->render('manage', array(
            "model" => $model
        ));
    }


    public function actionCreate()
    {
        $model = new Page(ActiveRecord::SCENARIO_CREATE);
        $form  = new Form('content.PageForm', $model);
        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
        {
            $this->redirect(array(
                'view',
                'id' => $model->id
            ));
        }
        $this->render('create', array('form' => $form));
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
            $this->render('view', array('model' => $model));
        }
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $form  = new Form('content.PageForm', $model);

        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
        {
            $this->redirect(array(
                'view',
                'id' => $model->id
            ));
        }

        $this->render('update', array(
            'form' => $form,
        ));
    }


    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        if (!isset($_GET['ajax']))
        {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }


    public function actionGetJsonData($id)
    {
        echo CJSON::encode($this->loadModel($id));
    }
}
