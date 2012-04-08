<?

class LanguageMessageAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            'Manage'        => 'Управление переводами',
            'Update'        => 'Редактирование переводов',
            'Create'        => 'Добавление переводов',
            'Delete'        => 'Удаление переводов',
            'NotUsableList' => 'Неиспользуемые переводы'
        );
    }


    public function actionManage()
    {
        $model = new LanguageMessage(ActiveRecord::SCENARIO_SEARCH);
        $model->unsetAttributes();

        if (isset($_GET['LanguageMessage']))
        {
            $model->attributes = $_GET['LanguageMessage'];
        }

        $this->render('manage', array(
            'model'     => $model,
            'languages' => Language::getCachedArray()
        ));
    }


    public function actionCreate()
    {
        $language_message = new LanguageMessage();

        $form = new Form('main.LanguageTranslationForm', $language_message);

        if (isset($_POST['LanguageMessage']))
        {
            $language_message->attributes   = $_POST['LanguageMessage'];
            $language_message->translations = $_POST['LanguageMessage']['translations'];
            if ($language_message->save())
            {
                $this->redirect(array('manage'));
            }
        }

        $this->render('create', array(
            'form' => $form
        ));
    }


    public function actionUpdate($id)
    {
        $language_message = $this->loadModel($id);

        $form = new Form('main.LanguageTranslationForm', $language_message);

        if (isset($_POST['LanguageMessage']))
        {
            $language_message->attributes   = $_POST['LanguageMessage'];
            $language_message->translations = $_POST['LanguageMessage']['translations'];
            if ($language_message->save())
            {
                $this->redirect(array('manage'));
            }
        }

        $this->render('update', array(
            'form' => $form
        ));
    }


    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        if (!isset($_POST['ajax']))
        {
            $this->redirect(array('manage'));
        }
    }


    public function actionNotUsableList()
    {
        $ds = DIRECTORY_SEPARATOR;

        $modules_dirs = scandir(MODULES_PATH);
        foreach ($modules_dirs as $module_dir)
        {
            if ($module_dir[0] == '.')
            {
                continue;
            }

            $views_dir = MODULES_PATH . $module_dir . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
            if (!is_dir($views_dir))
            {
                continue;
            }

            $views_dirs = scandir($views_dir);
            foreach ($views_dirs as $views_dir)
            {
                if ($views_dir[0] == '.')
                {
                    continue;
                }
            }

            $views_files_path = MODULES_PATH . DIRECTORY_SEPARATOR . $module_dir . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $views_dir;

            $views_files = scandir($views_files_path);
            foreach ($views_files as $view_file)
            {
                if ($view_file[0] == '.')
                {
                    continue;
                }

                $content = file_get_contents($views_files_path . DIRECTORY_SEPARATOR . $view_file);

                preg_match_all('#t\(([a-zA-Zа-Я]+)\);#', $content, $messages);
            }
        }

        $this->render('notUsableList');
    }


    public function loadModel($id)
    {
        $model = LanguageMessage::model()->findByPk($id);
        if (!$model)
        {
            $model->pageNotFound();
        }

        return $model;
    }
}
