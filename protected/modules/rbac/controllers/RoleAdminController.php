<?

class RoleAdminController extends AdminController
{   
    public static function actionsTitles() 
    {
        return array(
            "create" => "Добавление роли",
            "update" => "Редактирование роли",
            "manage" => "Управление ролями",
            "delete" => "Удаление роли",
        );
    }


	public function actionManage()
	{
        $this->render('manage', array(
            'roles' => Yii::app()->authManager->roles
        ));
	}


    public function actionUpdate($name)
    {
        $model = $this->loadModel($name);

        $this->performAjaxValidation($model);

        $form = new Form('rbac.RoleForm', $model);
        if ($form->submitted() && $model->save())
        {
            $this->redirect(array('manage'));
        }

        $this->render('update', array(
            'form' => $form
        ));
    }


    public function actionCreate()
    {
        $model = new AuthItem();
        $model->type = CAuthItem::TYPE_ROLE;

        $form = new Form('rbac.RoleForm', $model);

        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
        {
            $this->redirect(array('manage'));
        }

        $this->render('create', array(
            'form' => $form
        ));
    }


    public function actionDelete($name)
    {
        $this->loadModel($name)->delete();
    }


    public function loadModel($name)
    {
        $model = AuthItem::model()->findByAttributes(array(
            'name' => $name,
            'type' => CAuthItem::TYPE_ROLE
        ));

        if (!$model)
        {
            $this->pageNotFound();
        }

        return $model;
    }
}
