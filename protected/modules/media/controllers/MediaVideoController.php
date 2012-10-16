<?
class MediaVideoController extends ClientController
{

    public static function actionsTitles()
    {
        return [
            "manage"    => "Альбомы пользователя",
        ];
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
                'label'   => Yii::app()->user->isGuest
                    ? : t('Ваши') . '(' . Page::model()->count('user_id = ' . Yii::app()->user->id) . ')',
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
                        'widget',
                        'content.portlets.SectionCreateSidebar',
                    ],
                    [
                        'widget',
                        'tags.portlets.TagCreateSidebar',
                    ],
                    [
                        'partial',
                        'content.views.page._sidebarFormNotices'
                    ]
                ]
            ],
            [
                'actions'  => ['index'],
                'sidebars' => [
                    [
                        'widget',
                        'content.portlets.PageSectionsSidebar'
                    ],
                    [
                        'widget',
                        'comments.portlets.CommentsSidebar',
                    ],
                    [
                        'widget',
                        'media.portlets.YouTubePlayList'
                    ]
                    /*[
                        'widget',
                        'content.portlets.NavigatorSidebar',
                    ],*/
                ]
            ],
            [
                'actions'  => ['view'],
                'sidebars' => [
                    [
                        'widget',
                        'content.portlets.PageInfoSidebar'
                    ]
                ]
            ],
            [
                'actions'  => ['userPages'],
                'sidebars' => [
                    [
                        'widget',
                        'content.portlets.userPagesSidebar'
                    ]
                ]
            ],
        ];
    }


    public function actionManage($user_id = null)
    {
        if ($user_id === null)
        {
            $user_id = Yii::app()->user->model->id;
        }
        $user = User::model()->throw404IfNull()->findByPk($user_id);
        $this->page_title = 'Альбомы пользователя ' . $user->getLink();
        $dp = MediaFile::model()->getDataProvider($user);
        $this->render('userVideos', [
            'model' => $user,
            'is_my' => Yii::app()->user->model->id == $user_id,
            'dp'    => $dp
        ]);
    }
}
