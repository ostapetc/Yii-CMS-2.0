<?

class PageController extends ClientController
{
    public function filters()
    {
        return CMap::mergeArray(
            parent::filters(),
            [
                [
                    'application.modules.social.components.filters.ViewsSaveFilter',
                    'model_id' => 'Page'
                ]
            ]
        );
    }


    public static function actionsTitles()
    {
        return [
            'view'         => 'Просмотр поста',
            'main'         => 'Главная страница',
            'create'       => 'Новый пост',
            'update'       => 'Редактирование поста',
            'index'        => 'Все посты',
            'userPages'    => 'Посты пользователя',
            'sectionPages' => 'Посты раздела',
            'tagPages'     => 'Посты тега',
            'sitemap'      => 'Карта сайта',
        ];
    }


    public function actionSitemap()
    {
        $this->render('sitemap');
    }

    public function subMenuItems()
    {
        return [
            [
                'label' => t('Все'),
                'url'   => ['content/page/index']
            ],
            [
                'label' => t('Лучшие'),
                'url'   => ['content/page/top']
            ],
            [
                'label'   => Yii::app()->user->isGuest ?: t('Ваши') . '(' . Page::model()->count('user_id = ' . Yii::app()->user->id) . ')',
                'url'     => ['/page/user/' . Yii::app()->user->id],
                'visible' => !Yii::app()->user->isGuest
            ]
        ];
    }


    public function sidebars()
    {
        return [
            [
                'actions'  => ['create', 'update'],
                'sidebars' => [
                    [
                        'type' => 'widget',
                        'content.portlets.SectionCreateSidebar'
                    ],
                    [
                        'type' => 'widget',
                        'class' => 'tags.portlets.TagCreateSidebar',
                    ],
                    [
                        'type' => 'partial',
                        'class' => 'content.views.page._sidebarFormNotices',
                    ],
                ]
            ],
            [
                'actions'  => ['index'],
                'sidebars' => [
                    [
                        'type' => 'widget',
                        'class' => 'content.portlets.PageSectionsSidebar',
                    ],
                    [
                        'type' => 'widget',
                        'class' => 'comments.portlets.CommentsSidebar',
                    ],
                    [
                        'type' => 'widget',
                        'class' => 'content.portlets.NavigatorSidebar',
                    ],
                ]
            ],
            [
                'actions'  => ['view'],
                'sidebars' => [
                    [
                        'type' => 'widget',
                        'class' => 'content.portlets.PageInfoSidebar'
                    ]
                ]
            ],
            [
                'actions'  => ['userPages'],
                'sidebars' => [
                    [
                        'type' => 'widget',
                        'class' => 'content.portlets.userPagesSidebar'
                    ]
                ]
            ],
            [
                'type' => 'widget',
                'class' => 'media.portlets.VideoPlayList',
            ],
        ];
    }


    public function actionView($id)
    {
        $page = Page::model()->language()->findByPk($id);
        if (!$page)
        {
            $this->pageNotFound();
        }
        $this->render("view", [
            "page" => $page
        ]);
    }


    public function actionMain()
    {
        $this->render('main', []);
    }


    public function actionCreate()
    {
        $model = new Page(ActiveRecord::SCENARIO_CREATE);
        $form  = new Form('content.PageCForm', $model);
        $this->performAjaxValidation($model);

        if ($form->submitted() && $model->save())
        {
            $this->redirect(['view', 'id' => $model->id]);
        }

        $this->render('create', [
            'form' => $form
        ]);
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
            $this->redirect(['view', 'id' => $model->id]);
        }

        $this->render('update', [
            'form' => $form
        ]);
    }


    public function actionIndex()
    {
        $this->page_title = '';

        $criteria = new CDbCriteria();
        $criteria->compare('status', Page::STATUS_PUBLISHED);
        $criteria->compare('type', Page::TYPE_POST);
        $criteria->with   = ['tags'];
        $criteria->order  = 'date_create DESC';

        $data_provider = new CActiveDataProvider('Page', [
            'criteria'   => $criteria,
            'pagination' => [
                'pageSize' => '20'
            ]
        ]);

        $this->render('index', [
            'data_provider' => $data_provider
        ]);
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
//        $criteria->with  = ['tags', 'sections'];
//        $criteria->order = 't.date_create DESC';
//        $criteria->join  = "INNER JOIN {$section_rel_table}
//                                ON  {$section_rel_table}.section_id = {$section_id}";
//
        $data_provider = new CActiveDataProvider('Page', [
            'criteria'   => $criteria,
            'pagination' => [
              'pageSize' => '10'
            ]
        ]);
        //count($data_provider->getTotalItemCount()); die;
        $this->render('index', [
            'data_provider' => $data_provider,
            'section'       => $section
        ]);
    }


    public function actionTagPages($tag_name)
    {
        $tag = Tag::model()->findByAttributes(['name' => $tag_name]);
        if (!$tag)
        {
            $this->pageNotFound();
        }

        $this->page_title = t('Страницы с тегом') . ' ' . $tag->name;

        $tag_rel_table = TagRel::model()->tableName();

        $criteria = new CDbCriteria();
        $criteria->compare('t.status', Page::STATUS_PUBLISHED);
        $criteria->with = ['tags', 'sections'];

        $criteria->addCondition("t.id IN (
            SELECT object_id FROM {$tag_rel_table}
                WHERE tag_id = {$tag->id} AND
                       model_id  = 'Page'
        )");

        $data_provider = new CActiveDataProvider('Page', [
            'criteria'   => $criteria,
            'pagination' => [
                'pageSize' => '10'
            ]
        ]);

        $this->render('index', [
            'data_provider' => $data_provider,
            'tag'           => $tag
        ]);
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
        $criteria->with  = ['tags'];
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

        $data_provider = new CActiveDataProvider('Page', [
            'criteria'   => $criteria,
            'pagination' => [
              'pageSize' => '10'
            ]
        ]);

        $this->render('userPages', [
            'data_provider' => $data_provider,
            'widget'        => $widget,
            'user'          => $user,
            'model'         => isset($model) ? $model : null
        ]);
    }


    public static function displayWidgets()
    {
        return [
            'list' => t('показывать списком'),
            'grid' => t('показывать таблицей')
        ];
    }   
}
