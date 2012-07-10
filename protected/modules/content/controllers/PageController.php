<?

class PageController extends Controller
{
    public static function actionsTitles()
    {
        return array(
            'view'         => 'Просмотр страницы',
            'main'         => 'Главная страница',
            'create'       => 'Новая страница',
            'update'       => 'Редактирование страницы',
            'index'        => 'Список страниц',
            'userPages'    => 'Страницы пользователя',
            'sectionPages' => 'Страницы раздела',
        );
    }


    public function sidebars()
    {
        return array(
            array(
                'actions'  => array('create', 'update'),
                'sidebars' => array(
                    'widget'  => 'application.modules.content.portlets.SectionCreateSidebar',
                    'partial' => 'application.modules.content.views.page._sidebarFormNotices',
                )
            ),
            array(
                'actions'  => array('index'),
                'sidebars' => array(
                    'widget' => 'application.modules.content.portlets.NavigatorSidebar',
                    'widget' => 'application.modules.comments.portlets.CommentsSidebar'
                )
            ),
            array(
                'actions'  => array('userPages'),
                'sidebars' => array(
                    'widget' => 'application.modules.content.portlets.userPagesSidebar'
                )
            ),
        );
    }


    public function actionView($id)
    {
        $page = Page::model()->language()->findByPk($id);
        if (!$page)
        {
            $this->pageNotFound();
        }

        $this->render("view", array(
            "page" => $page
        ));
    }


    public function actionMain()
    {
        $this->render('main', array());
    }


    public function actionCreate()
    {
        $model = new Page(ActiveRecord::SCENARIO_CREATE);
        $form  = new Form('content.PageCForm', $model);

        if ($form->submitted() && $model->save())
        {
            $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'form' => $form
        ));
    }


    public function actionUpdate($id)
    {
        $model = Page::model()->findByPk($id);
        if (!$model)
        {
            $this->pageNotFound();
        }

        $form = new Form('content.PageCForm', $model);

        if ($form->submitted() && $model->save())
        {
            $model->updateSectionsRels();
            $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'form' => $form
        ));
    }


    public function actionIndex()
    {
        $data_provider = new CActiveDataProvider('Page', array(
            'criteria' => array(
                'condition' => "status = '" . Page::STATUS_PUBLISHED . "'",
                'order'     => 'date_create DESC',
                'with'      => array('tags')
            ),
            'pagination' => array(
                'pageSize' => '10'
            )
        ));

        $this->render('index', array(
            'data_provider' => $data_provider,
        ));
    }


    public function actionSectionPages($section_id)
    {
        $section = PageSection::model()->findByPk($section_id);
        if (!$section)
        {
            $this->pageNotFound();
        }

        $criteria = new CDbCriteria();
        $criteria->compare('t.status', Page::STATUS_PUBLISHED);
        $criteria->order = 't.date_create DESC';
        $criteria->with  = array('tags', 'sections_rels');
        $criteria->together = true;

        $criteria->compare('sections_rels.sections_id', $section->id);

        $data_provider = new CActiveDataProvider('Page', array(
            'criteria'   => $criteria,
            'pagination' => array(
              'pageSize' => '10'
            )
        ));

        $this->render('index', array(
            'data_provider' => $data_provider,
        ));
    }


    public function actionUserPages($user_id, $widget = 'list')
    {
        $widgets = self::displayWidgets();
        if (!isset($widgets[$widget]))
        {
            $this->pageNotFound();
        }

        $user = User::model()->findByPk($user_id);
        if (!$user)
        {
            $this->pageNotFound();
        }

        $criteria = new CDbCriteria();
        $criteria->with  = array('tags');
        $criteria->order = 'date_create DESC';

        $is_owner = !Yii::app()->user->isGuest && (Yii::app()->user->id == $user->id);

        if ($is_owner)
        {
            $this->page_title = t('Ваши страницы');

            $model = new Page(ActiveRecord::SCENARIO_SEARCH);
            $model->unsetAttributes();

            if (isset($_GET['Page']))
            {
                $model->attributes = $_GET['Page'];
            }

            $criteria->compare('status', $model->status);
        }
        else
        {
            $this->page_title = t("Страницы пользователя " . "(" . $user->name . ")");

            $criteria->compare('status', Page::STATUS_PUBLISHED);
        }

        $data_provider = new CActiveDataProvider('Page', array(
            'criteria'   => $criteria,
            'pagination' => array(
              'pageSize' => '10'
            )
        ));

        $this->render('userPages', array(
            'data_provider' => $data_provider,
            'widget'        => $widget,
            'user'          => $user,
            'model'         => isset($model) ? $model : null
        ));
    }


    public static function displayWidgets()
    {
        return array(
            'list' => t('показывать списком'),
            'grid' => t('показывать таблицей')
        );
    }   
}
