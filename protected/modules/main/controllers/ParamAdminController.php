<?

class ParamAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'View'   => 'Просмотр параметра',
            'Create' => 'Добавление параметра',
            'Update' => 'Редактирование параметра',
            'Manage' => 'Управление параметрами',
            'Delete' => 'Удаление параметра'
        );
    }


    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }


    public function actionCreate()
    {
        $model = new Param(ActiveRecord::SCENARIO_CREATE);

        $this->performAjaxValidation($model);

        $form = new Form('main.ParamForm', $model);

        if ($form->submitted('submit') && $model->save())
        {
            $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'form' => $form
        ));
    }


    public function actionUpdate($id, $scenario = 'update')
    {
        $model = $this->loadModel($id);
        $model->scenario = $scenario;

        $this->performAjaxValidation($model);

        $form = new Form('main.ParamForm', $model);

        if ($form->submitted() && $model->save())
        {
            $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'form' => $form,
        ));
    }


    public function actionManage($module_id = null)
    {
        $model = new Param('search');
        $model->unsetAttributes();

        if (isset($_GET['Param']))
        {
            $model->attributes = $_GET['Param'];
        }

        $params = array(
            'model' => $model
        );

        if ($module_id)
        {
            $params['module_id'] = $module_id;
            $params['module_name'] = AppManager::getModuleName($module_id);
        }

        $this->render('manage', $params);
    }


    public function actionDelete($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

}
