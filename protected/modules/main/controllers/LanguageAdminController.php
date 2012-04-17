<?

class LanguageAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "Create"           => "Добавление языка",
            "Update"           => "Редактирование языка",
            "Delete"           => "Удаление языка",
            "Manage"           => "Управление языками",
            "CreateTableField" => "Добавление поля 'language' к таблице"
        );
    }


    public function actionCreate()
    {
        $model = new Language;

        $this->performAjaxValidation($model);
        $form = new Form('main.LanguageForm', $model);

        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->save())
            {
                $this->redirect($this->createUrl('manage'));
            }
        }

        $this->render('create', array(
            'form' => $form,
        ));
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);
        $form = new Form('main.LanguageForm', $model);

        if ($form->submitted('submit'))
        {
            $model = $form->model;
            if ($model->save())
            {    print_r($model->getErrors());
                die;
                $this->redirect($this->createUrl('manage'));
            }
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
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('manage'));
        }
    }


    public function actionManage()
    {
        $model = new Language('search');
        $model->unsetAttributes();
        if (isset($_GET['Language']))
        {
            $model->attributes = $_GET['Language'];
        }

        $this->render('manage', array(
            'model' => $model,
        ));
    }


    public function actionCreateTableField($model)
    {
        $model = ActiveRecord::model($model);
        $table = $model->tableName();
        $meta  = $model->meta();

        if (!isset($meta['language']))
        {
            $sql = "ALTER TABLE `{$table}`
                          ADD `language` char(2) DEFAULT 'ru' COMMENT 'Язык' AFTER `id`";

            Yii::app()->db->createCommand($sql)->execute();

            $sql = "ALTER TABLE `{$table}` ADD CONSTRAINT `{$table}_language_fk` FOREIGN KEY (`language`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE";

            Yii::app()->db->createCommand($sql)->execute();
        }

        $this->redirect('/');
    }
}
