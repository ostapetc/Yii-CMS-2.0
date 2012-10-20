<?

class PageController extends ClientController
{
    public function filters()
    {
        return CMap::mergeArray(
            parent::filters(),
            array(
                array(
                    'application.modules.social.components.filters.ViewsSaveFilter',
                    'model_id' => 'Page'
                )
            )
        );
    }


    public static function actionsTitles()
    {
        return array(
            'view'         => 'Просмотр поста',
            'main'         => 'Главная страница',
            'create'       => 'Новый пост',
            'update'       => 'Редактирование поста',
            'index'        => 'Все посты',
            'userPages'    => 'Посты пользователя',
            'sectionPages' => 'Посты раздела',
            'tagPages'     => 'Посты тега',
            'sitemap'      => 'Карта сайта',
        );
    }


    public function actionSitemap()
    {
        $this->render('sitemap');
    }

    public function subMenuItems()
    {
        return array(
            array(
                'label' => t('Все'),
                'url'   => array('content/page/index')
            ),
            array(
                'label' => t('Лучшие'),
                'url'   => array('content/page/top')
            ),
            array(
                'label'   => Yii::app()->user->isGuest ?: t('Ваши') . '(' . Page::model()->count('user_id = ' . Yii::app()->user->id) . ')',
                'url'     => array('/page/user/' . Yii::app()->user->id),
                'visible' => !Yii::app()->user->isGuest
            )
        );
    }


    public function sidebars()
    {
        return array(
            array(
                'actions'  => array('create', 'update'),
                'sidebars' => array(
                    array(
                        'type' => 'widget',
                        'content.portlets.SectionCreateSidebar'
                    ),
                    array(
                        'type' => 'widget',
                        'class' => 'tags.portlets.TagCreateSidebar',
                    ),
                    array(
                        'type' => 'partial',
                        'class' => 'content.views.page._sidebarFormNotices',
                    ),
            ),
            array(
                'actions'  => array('index'),
                'sidebars' => array(
                    array(
                        'type' => 'widget',
                        'class' => 'content.portlets.PageSectionsSidebar',
                    ),
                    array(
                        'type' => 'widget',
                        'class' => 'comments.portlets.CommentsSidebar',
                    ),
                    array(
                        'type' => 'widget',
                        'class' => 'media.portlets.YouTubePlayList',
                    ),
                    array(
                        'type' => 'widget',
                        'class' => 'content.portlets.NavigatorSidebar',
                    ),
                )
            ),
            array(
                'actions'  => array('view'),
                'sidebars' => array(
                    array(
                        'type' => 'widget',
                        'class' => 'content.portlets.PageInfoSidebar'
                    )
                )
            ),
            array(
                'actions'  => array('userPages'),
                'sidebars' => array(
                    array(
                        'type' => 'widget',
                        'class' => 'content.portlets.userPagesSidebar'
                    )
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
        $this->performAjaxValidation($model);

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
        $this->page_title = '';

        $criteria = new CDbCriteria();
        $criteria->compare('status', Page::STATUS_PUBLISHED);
        $criteria->compare('type', Page::TYPE_POST);
        $criteria->with   = array('tags');
        $criteria->order  = 'date_create DESC';

        $data_provider = new CActiveDataProvider('Page', array(
            'criteria'   => $criteria,
            'pagination' => array(
                'pageSize' => '20'
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

        $this->page_title = $section->name;

        $section_rel_table = PageSectionRel::model()->tableName();

        $criteria = new CDbCriteria();
//        $criteria->compare('t.status', Page::STATUS_PUBLISHED);
//        $criteria->with  = array('tags', 'sections');
//        $criteria->order = 't.date_create DESC';
//        $criteria->join  = "INNER JOIN {$section_rel_table}
//                                ON  {$section_rel_table}.section_id = {$section_id}";
//
        $data_provider = new CActiveDataProvider('Page', array(
            'criteria'   => $criteria,
            'pagination' => array(
              'pageSize' => '10'
            )
        ));
        //count($data_provider->getTotalItemCount()); die;
        $this->render('index', array(
            'data_provider' => $data_provider,
            'section'       => $section
        ));
    }


    public function actionTagPages($tag_name)
    {
        $tag = Tag::model()->findByAttributes(array('name' => $tag_name));
        if (!$tag)
        {
            $this->pageNotFound();
        }

        $this->page_title = t('Страницы с тегом') . ' ' . $tag->name;

        $tag_rel_table = TagRel::model()->tableName();

        $criteria = new CDbCriteria();
        $criteria->compare('t.status', Page::STATUS_PUBLISHED);
        $criteria->with = array('tags', 'sections');

        $criteria->addCondition("t.id IN (
            SELECT object_id FROM {$tag_rel_table}
                WHERE tag_id = {$tag->id} AND
                       model_id  = 'Page'
        )");

        $data_provider = new CActiveDataProvider('Page', array(
            'criteria'   => $criteria,
            'pagination' => array(
                'pageSize' => '10'
            )
        ));

        $this->render('index', array(
            'data_provider' => $data_provider,
            'tag'           => $tag
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
