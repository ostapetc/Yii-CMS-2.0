<?

class PageController extends Controller
{
    public static function actionsTitles()
    {
        return array(
            'view'   => 'Просмотр страницы',
            'main'   => 'Главная страница',
            'create' => 'Новая страница',
            'update' => 'Редактирование страницы',
            'index'  => 'Список страниц'
        );
    }


    public function sidebars()
    {
        return array(
            array(
                'actions'  => array('create', 'update'),
                'sidebars' => array(
                    'widget'  => 'application.modules.content.portlets.sectionCreate',
                    'partial' => 'application.modules.content.views.page._sidebarFormNotices',
                )
            ),
            array(
                'actions'  => array('index'),
                'sidebars' => array(
                    'widget' => 'application.modules.content.portlets.navigator'
                )
            )
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
}
